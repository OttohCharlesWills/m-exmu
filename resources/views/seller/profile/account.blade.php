@extends('layouts.seller')

@section('sellercontent')
<div class="container py-5">
    <div class="row justify-content-center">
        {{-- ACCOUNT SETTINGS --}}
        {{-- <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Account Settings</h4>

                    <form method="POST"
                          action="{{ auth()->user()->role === 'admin'
                                ? route('admin.profile.account')
                                : route('blogger.profile.account') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text"
                                   class="form-control"
                                   name="name"
                                   value="{{ auth()->user()->name }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email"
                                   class="form-control"
                                   name="email"
                                   value="{{ auth()->user()->email }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                New Password <span class="text-muted">(optional)</span>
                            </label>
                            <input type="password"
                                   class="form-control"
                                   name="password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password"
                                   class="form-control"
                                   name="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary px-4">
                            Update Account
                        </button>
                    </form>
                </div>
            </div>
        </div> --}}

        {{-- AVATAR SETTINGS --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Profile Picture</h4>

                    <form method="POST"
                          enctype="multipart/form-data"
                          action="{{ route('seller.profile.avatar') }}">
                        @csrf

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <img
                                src="{{ auth()->user()->avatar ?? 'https://via.placeholder.com/120' }}"
                                class="rounded-circle border"
                                width="120"
                                height="120"
                                style="object-fit: cover;"
                                alt="Avatar">

                            <input type="file"
                                   class="form-control"
                                   name="avatar"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-success px-4">
                            Update Avatar
                        </button>
                    </form>
                    <form method="POST" action="{{ route('profile.delete') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-3">
                            Delete Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
