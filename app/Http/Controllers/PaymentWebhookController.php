<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductApprovalLog;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller

{
    public function handle(Request $request)
{
    $secret = config('services.flutterwave.secret_key');
    $signature = $request->header('verif-hash');

    if (!$signature || $signature !== $secret) {
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    $data = $request->all();

    if ($data['status'] === 'successful') {
        $sellerId = $data['meta']['seller_id'];
        $amount = $data['amount'];

        $wallet = Wallet::firstOrCreate(
            ['user_id' => $sellerId],
            ['balance' => 0]
        );

        $wallet->increment('balance', $amount);

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => 'credit',
            'source' => 'sale',
            'reference' => $data['id'],
            'status' => 'success',
        ]);
    }

    return response()->json(['status' => 'ok']);
}

}
