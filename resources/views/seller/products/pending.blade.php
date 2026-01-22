@extends('layouts.seller')

@section('sellercontent')
<h2 class="page-title">Pending Products</h2>

<div class="product-grid">
    @forelse($products as $product)
        <div class="product-card">
            <h3 class="product-name">{{ $product->name }}</h3>

            <div class="product-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>

            <p class="product-price">₦{{ number_format($product->price, 2) }}</p>

            <p class="product-desc">
                {{ Str::limit($product->description, 80) }}
            </p>

            <span class="status pending">Pending Approval</span>
        </div>
    @empty
        <p>No pending products.</p>
    @endforelse
</div>
@endsection
