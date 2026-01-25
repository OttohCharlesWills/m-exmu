<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Admin\ProductApprovalController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\Seller\WalletController;
use App\Http\Controllers\Seller\WithdrawalController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\SellerWalletController;
use App\Models\Product;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', function () {
    return view('/welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    // Seller product routes
    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/pending', [ProductController::class, 'pending'])->name('products.pending');

    });

    // Admin approval routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/products/pending', [ProductApprovalController::class, 'index'])->name('products.pending');
        Route::post('/products/{id}/approve', [ProductApprovalController::class, 'approve'])->name('products.approve');
        Route::post('/products/{id}/reject', [ProductApprovalController::class, 'reject'])->name('products.reject');
    });

});


Route::prefix('seller')->name('seller.')->middleware('auth')->group(function () {

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');

    Route::get('/wallet/withdraw', [WithdrawalController::class, 'create'])->name('wallet.withdraw');
    Route::post('/wallet/withdraw', [WithdrawalController::class, 'store'])->name('wallet.withdraw.store');
});


// Flutterwave webhook (public route)
Route::post('/flutterwave/webhook', [App\Http\Controllers\PaymentWebhookController::class, 'handle'])->name('flutterwave.webhook');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/pay/{product}', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');
// Route::get('/checkout/{product}', [CheckoutController::class, 'show'])->name('checkout.show');
// Route::post('/checkout/pay/{product}', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::post('/checkout/cart', [CheckoutController::class, 'guestCheckout']);
Route::get('/checkout/thank-you', function () {
    return view('buyer.thankyou');
})->name('checkout.thankyou');


// WELCOME PAGE PRODUCTS

Route::get('/', function() {
    // Get all approved products
    $products = Product::where('status', 'approved')->latest()->get();
    return view('welcome', compact('products'));
});

Route::get('/products/{product}/buy', [ProductController::class, 'buy'])->name('products.buy');



// FOR SELLER BANK DETAILS

Route::middleware(['auth'])->group(function () {
    Route::get('/seller/bank', [SellerWalletController::class, 'index'])->name('seller.wallet');
    Route::post('/seller/bank-account', [SellerWalletController::class, 'storeBank'])->name('seller.bank.store');
});

Route::post('/resolve-bank', [SellerWalletController::class, 'resolveBank'])
    ->middleware('auth');

