@extends('layouts.seller')

@section('sellercontent')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Settings</h4>

                    <div class="list-group">
                        <a href="{{ route('seller.profile.account') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-person-circle me-2"></i> Profile
                        </a>

                        {{-- Placeholder for future links --}}
                        <a href="{{ route('seller.changeofpassword.dob') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-key-fill me-2"></i> Change Password
                        </a>
                        <a href="{{ route('seller.wallet') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-bell-fill me-2"></i> Wallet
                        </a>
                        <a href="{{ route('profile.delete') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-gear-fill me-2"></i> Delete Account
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
