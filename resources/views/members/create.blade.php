@extends('layouts.app')

@section('title', 'Add Member | ComDonation')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Add Committee Member</h2>
            <p class="text-slate-400 text-sm">Register a new committee member & monthly pledge commitment.</p>
        </div>
        <a href="{{ route('members.index') }}" class="text-slate-400 hover:text-white text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <form action="{{ route('members.store') }}" method="POST" class="glass-card p-6 rounded-2xl space-y-5">
        @csrf

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Select Committee *</label>
            <select name="committee_id" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
                <option value="">-- Choose Committee --</option>
                @foreach($committees as $committee)
                    <option value="{{ $committee->id }}" {{ request('committee_id') == $committee->id ? 'selected' : '' }}>
                        {{ $committee->name }}
                    </option>
                @endforeach
            </select>
            @error('committee_id') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Member Full Name *</label>
            <input type="text" name="name" required placeholder="Full Name" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm">
            @error('name') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Mobile Number</label>
                <input type="text" name="phone" placeholder="+91 9876543210" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" placeholder="member@example.com" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm">
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Monthly Donation Pledge (₹) *</label>
            <input type="number" step="0.01" name="monthly_pledge_amount" value="1000" required placeholder="Monthly pledge amount" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm">
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Address</label>
            <textarea name="address" rows="2" placeholder="Residential / Business Address..." class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm"></textarea>
        </div>

        <input type="hidden" name="status" value="active">

        <div class="pt-4 flex items-center justify-end space-x-3">
            <a href="{{ route('members.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-sm font-semibold hover:bg-slate-700 transition">Cancel</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition">Save Member</button>
        </div>
    </form>
</div>
@endsection
