@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required>

                                @error('email')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Phone Number</label>
                            <div class="col-md-6">
                                <input id="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" required>

                                @error('phone')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- State --}}
                        @php
                            $states = [
                                "Abia","Adamawa","Akwa Ibom","Anambra","Bauchi","Bayelsa","Benue","Borno",
                                "Cross River","Delta","Ebonyi","Edo","Ekiti","Enugu","Gombe","Imo","Jigawa",
                                "Kaduna","Kano","Katsina","Kebbi","Kogi","Kwara","Lagos","Nasarawa","Niger",
                                "Ogun","Ondo","Osun","Oyo","Plateau","Rivers","Sokoto","Taraba","Yobe","Zamfara",
                                "FCT"
                            ];
                        @endphp

                        <div class="row mb-3">
                            <label for="state" class="col-md-4 col-form-label text-md-end">State</label>
                            <div class="col-md-6">
                                <select name="state" id="state"
                                    class="form-control @error('state') is-invalid @enderror" required>
                                    <option value="">-- Select State --</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('state')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>

                                @error('password')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">
                                Confirm Password
                            </label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password"
                                    class="form-control"
                                    name="password_confirmation" required>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
