@extends('layouts.seller')

@section('sellercontent')
<h2>My Products</h2>

@if($products->isEmpty())
    <p>No approved products yet.</p>
@endif

<div class="product-grid">
    @foreach($products as $product)
        <div class="product-card">
            <h3 class="product-name">{{ $product->name }}</h3>

            <div class="product-image">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                @else
                    <div class="no-image">No Image</div>
                @endif
            </div>

            <p class="product-price">₦{{ number_format($product->price, 2) }}</p>

            <p class="product-desc">
                {{ Str::limit($product->description, 80) }}
            </p>
            
            <p>Stock: {{ $product->quantity }}</p>
            
            <span class="badge bg-success">Approved</span>
        </div>
    @endforeach
</div>
@endsection
