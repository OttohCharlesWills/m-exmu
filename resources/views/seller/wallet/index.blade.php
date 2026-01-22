@extends('layouts.seller')

@section('sellercontent')
<h2>My Wallet</h2>

<div class="wallet-balance">
    <h3>Balance</h3>
    <p>₦{{ number_format($wallet->balance, 2) }}</p>
</div>

<a href="{{ route('seller.wallet.withdraw') }}">Withdraw Funds</a>

<h4>Transactions</h4>
<ul>
@foreach($transactions as $tx)
    <li>
        {{ ucfirst($tx->type) }} - ₦{{ number_format($tx->amount, 2) }}
        ({{ $tx->status }})
    </li>
@endforeach
</ul>
@endsection
