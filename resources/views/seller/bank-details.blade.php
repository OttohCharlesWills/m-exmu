@extends('layouts.seller')

@section('sellercontent')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Your Wallet</h2>

    {{-- Wallet Balance --}}
    <div class="mb-6 p-4 border rounded bg-gray-100">
        <p class="text-lg">
            Current Balance:
            <span class="font-bold">₦{{ number_format($wallet->balance, 2) }}</span>
        </p>
        <p>Status:
            <span class="font-medium">{{ ucfirst($wallet->status) }}</span>
        </p>
    </div>

    {{-- Bank Details --}}
    <div class="p-4 border rounded">
        <h3 class="text-xl font-semibold mb-3">Bank Details</h3>

        @if(session('success'))
            <div class="mb-3 p-2 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-3 p-2 bg-red-200 text-red-800 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('seller.bank.store') }}" method="POST">
            @csrf

            {{-- ACCOUNT NUMBER --}}
            <div class="mb-3">
                <label class="block font-medium mb-1">Account Number</label>
                <input
                    type="text"
                    id="account_number"
                    name="account_number"
                    maxlength="10"
                    class="w-full border p-2 rounded"
                    placeholder="Enter 10-digit account number"
                    required
                />
            </div>

            {{-- BANK --}}
            <div class="mb-3">
                <label class="block font-medium mb-1">Select Bank</label>
               <select
    name="bank_code"
    id="bank_code"
    class="w-full border p-2 rounded"
    disabled
    required
>
    <option value="">Select bank</option>

    @foreach(collect($banks)->sortBy('name') as $fwBank)
        <option value="{{ $fwBank['code'] }}"
            {{ optional($bankAccount)->bank_code == $fwBank['code'] ? 'selected' : '' }}>
            {{ $fwBank['name'] }}
        </option>
    @endforeach
</select>

            </div>

            {{-- ACCOUNT NAME --}}
            <div class="mb-3">
                <label class="block font-medium mb-1">Account Name</label>
                <input
                    type="text"
                    id="account_name"
                    name="account_name"
                    readonly
                    class="w-full border p-2 rounded bg-gray-100"
                    placeholder="Will auto-fill after verification"
                />
            </div>

            {{-- HIDDEN BANK NAME --}}
            <input type="hidden" name="bank_name" id="bank_name" />

            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                Save Bank Details
            </button>
        </form>

        {{-- VERIFIED BADGE --}}
        @if(optional($bankAccount)->is_verified)
            <p class="mt-3 text-green-600 font-medium">
                ✅ Bank details verified with Flutterwave
            </p>
        @endif
    </div>
</div>

{{-- AUTO VERIFY SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const acctInput  = document.getElementById('account_number');
    const bankSelect = document.getElementById('bank_code');
    const nameInput  = document.getElementById('account_name');
    const bankName   = document.getElementById('bank_name');

    let controller = null;

    acctInput.addEventListener('input', () => {
        nameInput.value = '';
        bankSelect.value = '';
        bankName.value = '';

        bankSelect.disabled = acctInput.value.trim().length !== 10;
    });

    bankSelect.addEventListener('change', () => {
        const accountNumber = acctInput.value.trim();
        const bankCode = bankSelect.value;

        if (!bankCode || accountNumber.length !== 10) return;

        if (controller) controller.abort();
        controller = new AbortController();

        nameInput.value = 'Verifying…';

        fetch('/resolve-bank', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                account_number: accountNumber,
                bank_code: bankCode
            }),
            signal: controller.signal
        })
        .then(res => res.json())
        .then(data => {
            if (data.account_name) {
                nameInput.value = data.account_name;
                bankName.value = bankSelect.options[bankSelect.selectedIndex].text;
            } else {
                nameInput.value = 'Account not found';
            }
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                nameInput.value = 'Verification failed';
            }
        });
    });
});
</script>
@endsection
