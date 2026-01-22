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

        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        return view('seller.bank-details', [
            'wallet' => $wallet,
            'bank' => $user->bankAccount
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
        'account_name' => 'required',
    ]);

    $user = auth()->user();

    $bank = SellerBankAccount::updateOrCreate(
        ['user_id' => $user->id],
        $request->only([
            'bank_name',
            'bank_code',
            'account_number',
            'account_name'
        ])
    );

    // 🔥 LOCAL MODE (no Flutterwave)
    if (app()->environment('local')) {
        $bank->update([
            'flutterwave_subaccount_id' => 'LOCAL_SUB_' . Str::random(12),
            'is_verified' => true
        ]);

        return back()->with('success', 'Bank details saved successfully.');
    }

    // 🌍 PRODUCTION MODE (real Flutterwave)
    $response = Http::withToken(config('services.flutterwave.secret_key'))
    ->timeout(30)
    ->post('https://api.flutterwave.com/v3/subaccounts', [
        'account_bank' => $bank->bank_code,
        'account_number' => $bank->account_number,
        'business_name' => $user->name,
        'business_email' => $user->email,
        'split_type' => 'percentage',
        'split_value' => 0.9,
        'business_mobile' => $user->phone ?? '08000000000',
    ]);

if ($response->failed()) {
    dd($response->status(), $response->body());
}


    $res = $response->json();

    if ($res['status'] !== 'success') {
        return back()->withErrors($res['message'] ?? 'Flutterwave error');
    }

    $bank->update([
        'flutterwave_subaccount_id' => $res['data']['id'],
        'is_verified' => true
    ]);

    return back()->with('success', 'Bank details saved successfully.');
}


}
