<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SellerUpgradeController extends Controller
{
    /**
     * Show upgrade plans
     */
    public function index()
    {
        $plan = Plan::where('slug', 'premium')
                    ->where('is_active', true)
                    ->firstOrFail();

        return view('seller.upgrade', compact('plan'));
    }

    /**
     * Initiate payment
     */
    public function pay(Request $request)
    {
        $plan = Plan::where('slug', 'premium')->firstOrFail();
        $user = auth()->user();

        $tx_ref = 'PREMIUM_' . Str::uuid();

        $response = Http::withToken(config('services.flutterwave.secret_key'))
            ->post('https://api.flutterwave.com/v3/payments', [
                'tx_ref' => $tx_ref,
                'amount' => $plan->price,
                'currency' => 'NGN',
                'redirect_url' => route('seller.upgrade.callback'),
                'customer' => [
                    'email' => $user->email,
                    'name' => $user->name,
                ],
                'meta' => [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                ],
                'customizations' => [
                    'title' => 'Premium Seller Upgrade',
                    'description' => 'Verified & Premium Seller Subscription',
                ],
            ]);

        return redirect($response['data']['link']);
    }

    /**
     * Payment callback
     */
    public function callback(Request $request)
    {
        $transaction_id = $request->transaction_id;

        $verify = Http::withToken(config('services.flutterwave.secret_key'))
            ->get("https://api.flutterwave.com/v3/transactions/{$transaction_id}/verify");

        if ($verify['status'] !== 'success') {
            return redirect()->route('seller.upgrade')->with('error', 'Payment verification failed');
        }

        $data = $verify['data'];
        $user = auth()->user();

        // Safety checks
        if (
            $data['customer']['email'] !== $user->email ||
            $data['status'] !== 'successful'
        ) {
            return redirect()->route('seller.upgrade')->with('error', 'Invalid payment');
        }

        $plan = Plan::find($data['meta']['plan_id']);

        // Upgrade user
        $user->update([
            'is_premium' => true,
            'is_verified' => true,
            'premium_expires_at' => now()->addDays($plan->duration_days),
        ]);

        return redirect()->route('seller.profile.account')
            ->with('success', 'You are now a Premium & Verified Seller 🎉');
    }
}
