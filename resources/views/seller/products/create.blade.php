@extends('layouts.seller')

@section('sellercontent')
<div class="page-title">
    <h2>Add New Product</h2>
    <p class="text-muted">Products are reviewed before appearing on the store.</p>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group mb-3">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
    </div>

    <div class="form-group mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" required>
    </div>

    <div class="form-group mb-4">
        <label>Product Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">
        Submit for Approval
    </button>
</form>
@endsection
