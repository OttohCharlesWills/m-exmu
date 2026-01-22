<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\ProductApprovalLog;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function create()
    {
        $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();
        return view('seller.wallet.withdraw', compact('wallet'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
        ]);

        $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();

        if ($wallet->balance < $request->amount) {
            return back()->withErrors('Insufficient balance');
        }

        $withdrawal = Withdrawal::create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'type' => 'debit',
            'source' => 'withdrawal',
            'status' => 'pending',
        ]);

        return redirect()->route('seller.wallet.index')
            ->with('success', 'Withdrawal request submitted');
    }
}


