@extends('layouts.seller')

@section('sellercontent')
<div class="container mx-auto px-4 py-6">

    <<h2>Welcome {{ Auth::user()->name }}</h2>

        <div class="grid">
            <!-- Box 1: Total Products -->
            <div class="card">
                <div class="icon-circle blue"><i class="bi bi-box-seam"></i></div>
                <div class="card-text">
                    <p class="label">Total Products</p>
                    <p class="value">120</p>
                </div>
            </div>

            <!-- Box 2: Total Orders -->
            <div class="card">
                <div class="icon-circle green"><i class="bi bi-cart-check"></i></div>
                <div class="card-text">
                    <p class="label">Total Orders</p>
                    <p class="value">58</p>
                </div>
            </div>

            <!-- Box 3: Total Sales -->
            <div class="card">
                <div class="icon-circle yellow"><i class="bi bi-currency-dollar"></i></div>
                <div class="card-text">
                    <p class="label">Total Sales</p>
                    <p class="value">$12,450</p>
                </div>
            </div>

            <!-- Box 4: Pending Shipments -->
            <div class="card">
                <div class="icon-circle red"><i class="bi bi-truck"></i></div>
                <div class="card-text">
                    <p class="label">Pending Shipments</p>
                    <p class="value">14</p>
                </div>
            </div>

            <!-- Box 5: Low Stock -->
            <div class="card">
                <div class="icon-circle purple"><i class="bi bi-exclamation-triangle"></i></div>
                <div class="card-text">
                    <p class="label">Low Stock</p>
                    <p class="value">8</p>
                </div>
            </div>

            <!-- Box 6: Returns -->
            <div class="card">
                <div class="icon-circle pink"><i class="bi bi-arrow-counterclockwise"></i></div>
                <div class="card-text">
                    <p class="label">Returns</p>
                    <p class="value">3</p>
                </div>
            </div>

            <!-- Box 7: Messages -->
            <div class="card">
                <div class="icon-circle indigo"><i class="bi bi-envelope"></i></div>
                <div class="card-text">
                    <p class="label">Messages</p>
                    <p class="value">12</p>
                </div>
            </div>

            <!-- Box 8: Reviews -->
            <div class="card">
                <div class="icon-circle teal"><i class="bi bi-star"></i></div>
                <div class="card-text">
                    <p class="label">Reviews</p>
                    <p class="value">25</p>
                </div>
            </div>
        </div>

</div>
@endsection
