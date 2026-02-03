<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\Transaction;

class CheckoutController extends Controller
{
    public function show(Product $product)
    {
        // Show product and "Buy Now" button
        return view('buyer.checkout', compact('product'));
    }

    public function pay(Request $request, Product $product)
    {
        $curl = curl_init();

        $tx_ref = 'order-' . $product->id . '-' . time();

        $data = [
    "tx_ref" => $tx_ref,
    "amount" => $product->price,
    "currency" => "NGN",
    "redirect_url" => route('checkout.callback'),
    "payment_options" => "card,mobilemoney,ussd",

    "customer" => [
        "email" => auth()->user()->email,
        "name" => auth()->user()->name
    ],

    "subaccounts" => [
        [
            "id" => $product->seller->flutterwave_subaccount_id,
            "transaction_split_ratio" => 85
        ]
    ],

    "meta" => [
        [
            "metaname"  => "product_id",
            "metavalue" => $product->id
        ],
        [
            "metaname"  => "seller_id",
            "metavalue" => $product->seller_id
        ]
    ]

];


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . config('services.flutterwave.secret_key')
            ],
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $res = json_decode($response);

        if ($res && $res->status === 'success') {
            return redirect($res->data->link);
        }

        return back()->withErrors('Payment initialization failed.');
    }

    public function guestCheckout(Request $request)
{
    $cart = $request->cart;
    $name = $request->name;
    $email = $request->email;

    // Example: send to Flutterwave
    $tx_ref = 'guest-' . time();
    $amount = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));

    $data = [
        "tx_ref" => $tx_ref,
        "amount" => $amount,
        "currency" => "NGN",
        "redirect_url" => route('checkout.callback'),
        "payment_options" => "card,mobilemoney,ussd",
        "customer" => [
            "email" => $email,
            "name" => $name
        ],
"meta" => [
    [
        "metaname"  => "cart",
        "metavalue" => json_encode($cart)
    ]
]

    ];

    // Flutterwave API call (same as your pay function)
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer " . config('services.flutterwave.secret_key')
        ]
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $res = json_decode($response);

    if($res && $res->status === 'success') {
        return response()->json(['success' => true, 'checkoutUrl' => $res->data->link]);
    }

    return response()->json(['success' => false]);
}


// public function callback(Request $request)
// {
//     $transaction_id = $request->transaction_id;

// $curl = curl_init();
// curl_setopt_array($curl, [
//     CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$transaction_id}/verify",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_HTTPHEADER => [
//         "Content-Type: application/json",
//         "Authorization: Bearer " . config('services.flutterwave.secret_key')
//     ],
// ]);

// $response = curl_exec($curl);
// curl_close($curl);

// $res = json_decode($response);

// // HARD GUARD — no vibes, only facts
// if (!$res || !isset($res->data)) {
//     return redirect('/failed')->with('error', 'Invalid payment response.');
// }

// if ($res->status === 'success' && $res->data->status === 'successful') {
//         if ($res->status === 'success' && $res->data->status === 'successful') {

//         // Store transaction in DB
//         $transaction = Transaction::create([
//             'tx_ref'         => $res->data->tx_ref,
//             'transaction_id' => $res->data->id,
//             'amount'         => $res->data->amount,
//             'currency'       => $res->data->currency,
//             'status'         => $res->data->status,

//             'buyer_email'    => $res->data->customer->email ?? $request->guestEmail,
//             'buyer_name'     => $res->data->customer->name ?? $request->guestName,

//             'product_id'     => $res->data->meta->product_id ?? null,
//             'seller_id'      => $res->data->meta->seller_id ?? null,
//         ]);

//         // Redirect to thank you page
//         return redirect()->route('checkout.thankyou', $transaction->id);
//     }

//     return redirect('/failed')->with('error', 'Payment was not successful.');
// }
// }

public function callback(Request $request)
{
    $transaction_id = $request->transaction_id;

    // VERIFY FROM FLUTTERWAVE
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$transaction_id}/verify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer " . config('services.flutterwave.secret_key')
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $res = json_decode($response);

    // HARD GUARD
    if (!$res || !isset($res->data)) {
        return redirect('/failed')->with('error', 'Invalid payment response.');
    }

    if ($res->status !== 'success' || $res->data->status !== 'successful') {
        return redirect('/failed')->with('error', 'Payment not successful.');
    }

    // PREVENT DOUBLE CREDIT
    if (Transaction::where('transaction_id', $res->data->id)->exists()) {
        return redirect('/')->with('info', 'Transaction already processed.');
    }

    // SAVE MAIN TRANSACTION
    $transaction = Transaction::create([
        'tx_ref'         => $res->data->tx_ref,
        'transaction_id' => $res->data->id,
        'amount'         => $res->data->amount,
        'currency'       => $res->data->currency,
        'status'         => $res->data->status,

        'buyer_email'    => $res->data->customer->email ?? null,
        'buyer_name'     => $res->data->customer->name ?? null,

        'product_id'     => $res->data->meta->product_id ?? null,
        'seller_id'      => $res->data->meta->seller_id ?? null,
    ]);

    /**
     * ============================
     * SELLER WALLET CREDIT
     * ============================
     */
    if (!empty($res->data->meta->seller_id)) {

        $sellerId = $res->data->meta->seller_id;

        // 👇 THIS SHOULD COME FROM META (BEST PRACTICE)
        $sellerAmount = $res->data->meta->seller_amount 
            ?? ($res->data->amount * 0.9); // fallback: 90%

        // GET OR CREATE WALLET
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $sellerId],
            ['balance' => 0]
        );

        // CREDIT WALLET
        $wallet->increment('balance', $sellerAmount);

        // LOG WALLET TRANSACTION
        WalletTransaction::create([
            'wallet_id'      => $wallet->id,
            'transaction_id' => $transaction->id,
            'amount'         => $sellerAmount,
            'type'           => 'credit',
            'status'         => 'completed',
            'description'    => 'Product sale payment',
        ]);
    }

    return redirect()->route('checkout.thankyou', $transaction->id);
}


}
