@extends('layouts.app')

@section('title', 'Record Donation | ComDonation')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Record New Donation</h2>
            <p class="text-slate-400 text-sm">Issue receipt and add donation entry to committee fund.</p>
        </div>
        <a href="{{ route('donations.index') }}" class="text-slate-400 hover:text-white text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <form action="{{ route('donations.store') }}" method="POST" class="glass-card p-6 rounded-2xl space-y-5">
        @csrf

        <div class="flex items-center justify-between bg-slate-900 p-3.5 rounded-xl border border-slate-800">
            <span class="text-xs font-semibold text-slate-400">Generated Receipt No:</span>
            <span class="font-mono font-bold text-emerald-400 text-sm">{{ $receiptNumber }}</span>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Target Committee *</label>
            <select name="committee_id" id="committeeSelect" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
                <option value="">-- Choose Committee --</option>
                @foreach($committees as $comm)
                    <option value="{{ $comm->id }}" {{ request('committee_id') == $comm->id ? 'selected' : '' }}>
                        {{ $comm->name }}
                    </option>
                @endforeach
            </select>
            @error('committee_id') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Optional Select Member -->
        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Select Registered Member (Optional)</label>
            <select id="memberSelect" name="member_id" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
                <option value="">-- Non-member / Guest Donor --</option>
                @foreach($members as $m)
                    <option value="{{ $m->id }}" data-name="{{ $m->name }}" data-phone="{{ $m->phone }}" data-committee="{{ $m->committee_id }}" {{ request('member_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->name }} ({{ $m->phone ?: 'No Phone' }}) - {{ $m->committee ? $m->committee->name : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Donor Full Name *</label>
                <input type="text" id="donorName" name="donor_name" value="{{ request('donor_name') }}" required placeholder="Donor Name" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm">
                @error('donor_name') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Donor Mobile Number</label>
                <input type="text" id="donorPhone" name="donor_phone" value="{{ request('donor_phone') }}" placeholder="+91 9876543210" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Amount (₹) *</label>
                <input type="number" step="0.01" name="amount" required placeholder="500.00" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white font-bold text-emerald-400 focus:outline-none focus:border-emerald-500 text-sm">
                @error('amount') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Payment Mode *</label>
                <select name="payment_method" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
                    <option value="cash">Cash</option>
                    <option value="upi">UPI / GPay / PhonePe</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="cheque">Cheque</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Payment Date *</label>
                <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Notes / Purpose / Transaction Ref</label>
            <textarea name="notes" rows="2" placeholder="Optional notes e.g., Monthly pledge for Sept 2026..." class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm"></textarea>
        </div>

        <div class="pt-4 flex items-center justify-end space-x-3">
            <a href="{{ route('donations.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-sm font-semibold hover:bg-slate-700 transition">Cancel</a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/25 hover:from-emerald-600 hover:to-teal-600 transition flex items-center space-x-2">
                <i class="fa-solid fa-receipt"></i>
                <span>Issue Donation Receipt</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const memberSelect = document.getElementById('memberSelect');
        const donorName = document.getElementById('donorName');
        const donorPhone = document.getElementById('donorPhone');
        const committeeSelect = document.getElementById('committeeSelect');

        memberSelect.addEventListener('change', function() {
            const selected = memberSelect.options[memberSelect.selectedIndex];
            if (selected.value) {
                if (selected.dataset.name) donorName.value = selected.dataset.name;
                if (selected.dataset.phone) donorPhone.value = selected.dataset.phone;
                if (selected.dataset.committee) committeeSelect.value = selected.dataset.committee;
            }
        });
    });
</script>
@endpush
