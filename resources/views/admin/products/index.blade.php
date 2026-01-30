@extends('layouts.admin')

@section('admincontent')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">All Products</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($products->count() === 0)
        <div class="alert alert-info">No products found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle" id="productsTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Seller</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $i => $product)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->seller->name ?? 'Unknown' }}</td>
                        <td>₦{{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge 
                                @if($product->status === 'approved') bg-success
                                @elseif($product->status === 'pending') bg-warning
                                @else bg-danger @endif">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="d-flex gap-1 flex-wrap">

                            {{-- VIEW --}}
                            <button class="btn btn-info btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#productModal"
                                    data-name="{{ $product->name }}"
                                    data-seller="{{ $product->seller->name ?? 'Unknown' }}"
                                    data-price="{{ number_format($product->price, 2) }}"
                                    data-description="{{ $product->description }}"
                                    data-image="{{ $product->image ?? 'https://via.placeholder.com/300' }}"
                                    data-status="{{ ucfirst($product->status) }}">
                                👁 View
                            </button>

                            {{-- APPROVE --}}
                            @if($product->status !== 'approved')
                            <form method="POST" action="{{ route('admin.products.approve', $product->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">✅ Approve</button>
                            </form>
                            @endif

                            {{-- REJECT --}}
                            @if($product->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.products.reject', $product->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">❌ Reject</button>
                            </form>
                            @endif

                            {{-- SET PENDING --}}
                            @if($product->status !== 'pending')
                            <form method="POST" action="{{ route('admin.products.pending-again', $product->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">⏳ Pending</button>
                            </form>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- MODAL --}}
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <img id="modalImage" src="" alt="" class="img-fluid rounded">
                </div>
                <div class="col-md-6">
                    <h4 id="modalName"></h4>
                    <p><strong>Seller:</strong> <span id="modalSeller"></span></p>
                    <p><strong>Price:</strong> ₦<span id="modalPrice"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p id="modalDescription"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var productModal = document.getElementById('productModal')
    productModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        document.getElementById('modalName').textContent = button.getAttribute('data-name')
        document.getElementById('modalSeller').textContent = button.getAttribute('data-seller')
        document.getElementById('modalPrice').textContent = button.getAttribute('data-price')
        document.getElementById('modalDescription').textContent = button.getAttribute('data-description')
        document.getElementById('modalImage').src = button.getAttribute('data-image')
        document.getElementById('modalStatus').textContent = button.getAttribute('data-status')
    })
</script>
@endsection

