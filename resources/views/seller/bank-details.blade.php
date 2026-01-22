@extends('layouts.seller')

@section('sellercontent')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Your Wallet</h2>

    {{-- Wallet Balance --}}
    <div class="mb-6 p-4 border rounded bg-gray-100">
        <p class="text-lg">Current Balance: <span class="font-bold">₦{{ number_format($wallet->balance, 2) }}</span></p>
        <p>Status: <span class="font-medium">{{ ucfirst($wallet->status) }}</span></p>
    </div>

    {{-- Bank Details Form --}}
    <div class="p-4 border rounded">
        <h3 class="text-xl font-semibold mb-3">Bank Details</h3>

        @if(session('success'))
            <div class="mb-3 p-2 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('seller.bank.store') }}" method="POST">
            @csrf

            {{-- Bank Name --}}
            <div class="mb-3">
                <label class="block font-medium mb-1">Bank Name</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $bank->bank_name ?? '') }}" 
                       class="w-full border p-2 rounded" required>
                @error('bank_name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bank Code Dropdown --}}
            <div class="mb-3">
                <label class="block font-medium mb-1">Bank</label>
                <select name="bank_code" class="w-full border p-2 rounded" required>
                    <option value="">Select your bank</option>
                    @php
                        $banks = [
                            '011' => 'First Bank',
                            '058' => 'GTBank',
                            '044' => 'Access Bank',
                            '033' => 'UBA',
                            '057' => 'Zenith Bank',
                            '032' => 'Union Bank',
                            '035' => 'Wema Bank',
                            '076' => 'Polaris Bank',
                            '050' => 'EcoBank',
                            '215' => 'Stanbic IBTC',
                            '232' => 'Sterling Bank',
                            '221' => 'Unity Bank',
                            '023' => 'CitiBank',
                            '301' => 'Jaiz Bank',
                            '070' => 'Keystone Bank',
                            '068' => 'Standard Chartered Bank',
                            '063' => 'Fidelity Bank',
                            '056' => 'Bank PHB / Heritage Bank'
                        ];
                    @endphp

                    @foreach($banks as $code => $name)
                        <option value="{{ $code }}" {{ (old('bank_code', $bank->bank_code ?? '') == $code) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('bank_code')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Account Number --}}
            <div class="mb-3">
                <label class="block font-medium mb-1">Account Number</label>
                <input type="text" name="account_number" value="{{ old('account_number', $bank->account_number ?? '') }}" 
                       class="w-full border p-2 rounded" required>
                @error('account_number')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Account Name --}}
            <div class="mb-3">
                <label class="block font-medium mb-1">Account Name</label>
                <input type="text" name="account_name" value="{{ old('account_name', $bank->account_name ?? '') }}" 
                       class="w-full border p-2 rounded" required>
                @error('account_name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save Bank Details
            </button>

        </form>

        {{-- Verified Badge --}}
        @if(isset($bank) && $bank->is_verified)
            <p class="mt-3 text-green-600">✅ Bank details verified with Flutterwave.</p>
        @endif
    </div>
</div>
@endsection
