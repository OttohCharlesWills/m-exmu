@extends('layouts.seller')

@section('sellercontent')
<h2>My Products</h2>

@if($products->isEmpty())
    <p>No approved products yet.</p>
@endif

<div class="product-grid">
    @foreach($products as $product)
        <div class="product-card">
            <h4>{{ $product->name }}</h4>
            <p>₦{{ number_format($product->price, 2) }}</p>
            <p>Stock: {{ $product->quantity }}</p>
            <span class="badge bg-success">Approved</span>
        </div>
    @endforeach
</div>
@endsection
