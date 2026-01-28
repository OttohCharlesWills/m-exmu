@extends('layouts.seller')

@section('sellercontent')
<div class="container py-5">
    <div class="row justify-content-center">

        {{-- ACCOUNT SETTINGS --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Account Settings</h4>

                    <form method="POST" action="{{ route('seller.profile.account') }}">
                        @csrf

                        {{-- NAME --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text"
                                   class="form-control"
                                   name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required>
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email"
                                   class="form-control"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required>
                        </div>

                        {{-- PHONE --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text"
                                   class="form-control"
                                   name="phone"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   required>
                        </div>

                        {{-- STATE --}}
                        @php
                            $states = [
                                "Abia","Adamawa","Akwa Ibom","Anambra","Bauchi","Bayelsa","Benue","Borno",
                                "Cross River","Delta","Ebonyi","Edo","Ekiti","Enugu","Gombe","Imo","Jigawa",
                                "Kaduna","Kano","Katsina","Kebbi","Kogi","Kwara","Lagos","Nasarawa","Niger",
                                "Ogun","Ondo","Osun","Oyo","Plateau","Rivers","Sokoto","Taraba","Yobe","Zamfara",
                                "FCT"
                            ];
                        @endphp

                        <div class="mb-3">
                            <label class="form-label fw-semibold">State</label>
                            <select name="state" class="form-control" required>
                                <option value="">-- Select State --</option>
                                @foreach($states as $state)
                                    <option value="{{ $state }}"
                                        {{ old('state', auth()->user()->state) == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ABOUT SELLER --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">About You</label>
                            <textarea
                                class="form-control"
                                name="about"
                                rows="4"
                                placeholder="Tell customers about yourself...">{{ old('about', auth()->user()->about) }}</textarea>
                        </div>

                        {{-- ACCOUNT STATUS / UPGRADE --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Account Status</label>

                            <div class="d-flex gap-2 flex-wrap mt-2">
                                {{-- NORMAL / PREMIUM --}}
                                @if(auth()->user()->is_premium)
                                    <span class="badge bg-warning text-dark">💎 Premium Seller</span>
                                @else
                                    <span class="badge bg-secondary">Normal Seller</span>
                                @endif

                                {{-- VERIFIED --}}
                                @if(auth()->user()->is_verified)
                                    <span class="badge bg-success">✔ Verified</span>
                                @else
                                    <span class="badge bg-dark">Not Verified</span>
                                @endif
                            </div>

                            {{-- UPGRADE CTA --}}
                            @if(!auth()->user()->is_premium || !auth()->user()->is_verified)
                                <div class="alert alert-info mt-3 mb-0">
                                    <strong>Want Premium & Verified?</strong><br>
                                    Get more visibility, customer trust, and priority listings.
                                </div>

                                <a href="{{ route('seller.upgrade') }}"
                                   class="btn btn-warning mt-3 w-100 fw-semibold">
                                    Upgrade to Premium
                                </a>
                            @endif
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                New Password <span class="text-muted">(optional)</span>
                            </label>
                            <input type="password"
                                   class="form-control"
                                   name="password">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password"
                                   class="form-control"
                                   name="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary px-4">
                            Save Changes
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
