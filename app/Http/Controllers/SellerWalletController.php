<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;         // <-- THIS fixes the Http:: calls
use App\Models\Wallet;                      // <-- Wallet model
use App\Models\SellerBankAccount;           // <-- Bank account model
use App\Models\User;  
use Illuminate\Support\Str;



class SellerWalletController extends Controller
{

public function index()
{
    $user = auth()->user();

    // Wallet
    $wallet = Wallet::firstOrCreate(
        ['user_id' => $user->id],
        ['balance' => 0]
    );

    // Fetch banks from Flutterwave (THE IMPORTANT PART)
    $banksResponse = Http::withToken(config('services.flutterwave.secret_key'))
        ->get('https://api.flutterwave.com/v3/banks/NG');

    if ($banksResponse->failed()) {
        abort(500, 'Unable to fetch banks from Flutterwave');
    }

    $banks = $banksResponse->json()['data'];

    return view('seller.bank-details', [
        'wallet' => $wallet,
        'bankAccount' => $user->bankAccount, // ✅ MATCHES BLADE
        'banks'  => $banks,             // flutterwave-approved banks
    ]);
}


    public function resolveBank(Request $request)
{
    $request->validate([
        'bank_code' => 'required',
        'account_number' => 'required|digits:10',
    ]);

    // LOCAL MODE — fake response
    if (app()->environment('local')) {
        return response()->json([
            'account_name' => 'JOHN DOE'
        ]);
    }

    // PRODUCTION — Flutterwave real resolve
    $url = "https://api.flutterwave.com/v3/accounts/resolve?account_number={$request->account_number}&account_bank={$request->bank_code}";

    $response = Http::withToken(config('services.flutterwave.secret_key'))
        ->timeout(30)
        ->get($url);

    // Log response for debugging
    logger('Flutterwave resolve response', $response->json());

    $res = $response->json();

    if (($res['status'] ?? '') !== 'success') {
        return response()->json(['account_name' => null], 400);
    }

    return response()->json([
        'account_name' => $res['data']['account_name']
    ]);
}



    // public function storeBank(Request $request)
    // {
    //     $request->validate([
    //         'bank_name' => 'required',
    //         'bank_code' => 'required',
    //         'account_number' => 'required|digits:10',
    //         'account_name' => 'required',
    //     ]);

    //     $user = auth()->user();

    //     $bank = SellerBankAccount::updateOrCreate(
    //         ['user_id' => $user->id],
    //         $request->only([
    //             'bank_name',
    //             'bank_code',
    //             'account_number',
    //             'account_name'
    //         ])
    //     );

    //     $response = Http::withToken(config('services.flutterwave.secret_key'))
    //         ->post('https://api.flutterwave.com/v3/subaccounts', [
    //             'account_bank' => $bank->bank_code,
    //             'account_number' => $bank->account_number,
    //             'business_name' => auth()->user()->name,
    //             'business_email' => auth()->user()->email,
    //             'split_type' => 'percentage', // or flat
    //             'split_value' => 90,          // seller gets 90%, admin 10%
    //             'business_mobile' => auth()->user()->phone,
    //         ]);

    //     $res = $response->json();

    //     if ($res['status'] === 'success') {
    //         $bank->flutterwave_subaccount_id = $res['data']['id'];
    //         $bank->is_verified = 1;
    //         $bank->save();
    //     }


    //     // 👇 LOCAL MODE — NO FLUTTERWAVE CALL
    //     // if (app()->environment('local')) {

    //     //     $bank->update([
    //     //         'flutterwave_subaccount_id' => 'LOCAL_SUB_' . Str::random(12),
    //     //         'is_verified' => true
    //     //     ]);

    //     //     return back()->with('success', 'Bank details saved (Local mode – subaccount mocked)');
    //     // }
    // }

    public function storeBank(Request $request)
{
    $request->validate([
        'bank_name' => 'required',
        'bank_code' => 'required',
        'account_number' => 'required|digits:10',
    ]);

    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | 1️⃣ VERIFY ACCOUNT WITH FLUTTERWAVE
    |--------------------------------------------------------------------------
    */
    $verify = Http::withToken(config('services.flutterwave.secret_key'))
        ->timeout(30)
        ->get('https://api.flutterwave.com/v3/accounts/resolve', [
            'account_number' => $request->account_number,
            'account_bank'   => $request->bank_code,
        ]);

    if ($verify->failed()) {
        return back()->withErrors([
            'account_number' => 'Unable to verify bank account. Try again.'
        ]);
    }

    $verifyRes = $verify->json();

    if (($verifyRes['status'] ?? '') !== 'success') {
        return back()->withErrors([
            'account_number' => $verifyRes['message'] ?? 'Invalid bank details'
        ]);
    }

    $resolvedName = $verifyRes['data']['account_name'];

    /*
    |--------------------------------------------------------------------------
    | 2️⃣ SAVE BANK DETAILS (REAL ACCOUNT NAME)
    |--------------------------------------------------------------------------
    */
    $bank = SellerBankAccount::updateOrCreate(
        ['user_id' => $user->id],
        [
            'bank_name'     => $request->bank_name,
            'bank_code'     => $request->bank_code,
            'account_number'=> $request->account_number,
            'account_name'  => $resolvedName,
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | 3️⃣ LOCAL MODE (MOCK)
    |--------------------------------------------------------------------------
    */
    if (app()->environment('local')) {
        $bank->update([
            'flutterwave_subaccount_id' => 'LOCAL_SUB_' . Str::random(12),
            'is_verified' => true
        ]);

        return back()->with('success', 'Bank verified & saved (local mode)');
    }

    /*
    |--------------------------------------------------------------------------
    | 4️⃣ CREATE FLUTTERWAVE SUBACCOUNT (PRODUCTION)
    |--------------------------------------------------------------------------
    */
    $response = Http::withToken(config('services.flutterwave.secret_key'))
        ->timeout(30)
        ->post('https://api.flutterwave.com/v3/subaccounts', [
            'account_bank'   => $bank->bank_code,
            'account_number' => $bank->account_number,
            'business_name'  => $user->name,
            'business_email' => $user->email,
            'business_mobile'=> $user->phone ?? '08000000000',
            'split_type'     => 'percentage',
            'split_value'    => 0.9,
        ]);

    if ($response->failed()) {
        logger()->error('Flutterwave subaccount error', $response->json());
        return back()->withErrors('Flutterwave subaccount creation failed');
    }

    $res = $response->json();

    if (($res['status'] ?? '') !== 'success') {
        return back()->withErrors($res['message'] ?? 'Flutterwave error');
    }

    $bank->update([
        'flutterwave_subaccount_id' => $res['data']['id'],
        'is_verified' => true
    ]);

    return back()->with('success', 'Bank verified & subaccount created');
}


// public function resolveBank(Request $request)
// {
//     $request->validate([
//         'bank_code' => 'required',
//         'account_number' => 'required|digits:10',
//     ]);

//     $response = Http::withToken(config('services.flutterwave.secret_key'))
//         ->timeout(30)
//         ->get('https://api.flutterwave.com/v3/accounts/resolve', [
//             'account_bank'   => $request->bank_code,
//             'account_number' => $request->account_number,
//         ]);

//     if ($response->failed()) {
//         return response()->json(['error' => 'Verification failed'], 422);
//     }

//     $res = $response->json();

//     if (($res['status'] ?? '') !== 'success') {
//         return response()->json(['error' => $res['message']], 422);
//     }

//     return response()->json([
//         'account_name' => $res['data']['account_name']
//     ]);
// }



}
