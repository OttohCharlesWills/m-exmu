@extends('layouts.seller')

@section('sellercontent')
<h2>Withdraw Funds</h2>

<p>Available balance: ₦{{ number_format($wallet->balance, 2) }}</p>

<form method="POST" action="{{ route('seller.wallet.withdraw.store') }}">
    @csrf

    <input type="number" name="amount" placeholder="Amount" required>
    <input type="text" name="bank_name" placeholder="Bank Name" required>
    <input type="text" name="account_number" placeholder="Account Number" required>
    <input type="text" name="account_name" placeholder="Account Name" required>

    <button type="submit">Request Withdrawal</button>
</form>
@endsection
