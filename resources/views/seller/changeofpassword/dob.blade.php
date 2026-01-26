@extends('layouts.seller')

@section('sellercontent')
<div class="container py-5">
    <div class="row justify-content-center">
        {{-- ACCOUNT SETTINGS --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Account Settings</h4>

                    <form method="POST"
                          action="{{route ('seller.profile.account') }}">
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
        </div>

    </div>
</div>
@endsection
