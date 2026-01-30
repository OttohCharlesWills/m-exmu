<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\ProductApprovalLog;
use Illuminate\Http\Request;

class WalletController extends Controller
{
public function index()
{
    $user = auth()->user();

    $wallet = Wallet::firstOrCreate(
        ['user_id' => $user->id],
        ['balance' => 0]
    );

    $transactions = $wallet->transactions()
        ->latest()
        ->limit(50) // don’t load 10k rows like a madman
        ->get();

    return view('seller.wallet.index', [
        'wallet' => $wallet,
        'transactions' => $transactions,
    ]);
}

}

