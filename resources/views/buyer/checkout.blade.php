<div class="container">
    <h2>Checkout: {{ $product->name }}</h2>
    <p>{{ $product->description }}</p>
    <p><strong>Price: ₦{{ number_format($product->price) }}</strong></p>

    <form method="POST" action="{{ route('checkout.pay', $product) }}">
        @csrf
        <button type="submit" class="btn btn-success">Buy Now</button>
    </form>
</div>