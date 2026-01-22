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
        $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0]
        );

        $transactions = $wallet->transactions()->latest()->get();

        return view('seller.wallet.index', compact('wallet', 'transactions'));
    }
}

