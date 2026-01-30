@extends('layouts.admin')

@section('admincontent')
<div class="container py-4">

    <h2 class="mb-4 fw-bold">Pending Product Approvals</h2>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count() === 0)
        <div class="alert alert-info">
            No pending products. Admin life is peaceful today 😌
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">

                        {{-- IMAGE --}}
                        @if($product->image)
                            <img src="{{ $product->image }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $product->name }}">
                        @else
                            <div class="no-image">No Image</div>
                        @endif

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>

                            <p class="text-muted mb-1">
                                Seller: {{ $product->seller->name ?? 'Unknown' }}
                            </p>

                            <p class="mb-1">
                                ₦{{ number_format($product->price, 2) }}
                            </p>

                            <p class="card-text small">
                                {{ Str::limit($product->description, 100) }}
                            </p>

                            <span class="badge bg-warning text-dark mb-3">
                                Pending Approval
                            </span>

                            {{-- APPROVE --}}
                            <form method="POST"
                                  action="{{ route('admin.products.approve', $product->id) }}"
                                  class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    ✅ Approve
                                </button>
                            </form>

                            {{-- REJECT --}}
                            <form method="POST"
                                  action="{{ route('admin.products.reject', $product->id) }}">
                                @csrf

                                <textarea
                                    name="admin_note"
                                    class="form-control mb-2"
                                    rows="2"
                                    placeholder="Reason for rejection..."
                                    required></textarea>

                                <button type="submit" class="btn btn-danger w-100">
                                    ❌ Reject
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
