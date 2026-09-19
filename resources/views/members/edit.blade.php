@extends('layouts.app')

@section('title', 'Edit Member | ComDonation')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Edit Member</h2>
            <p class="text-slate-400 text-sm">Update member details or monthly pledge amount.</p>
        </div>
        <a href="{{ route('members.index') }}" class="text-slate-400 hover:text-white text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <form action="{{ route('members.update', $member->id) }}" method="POST" class="glass-card p-6 rounded-2xl space-y-5">
        @csrf
        @method('PUT')

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Committee *</label>
            <select name="committee_id" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
                @foreach($committees as $committee)
                    <option value="{{ $committee->id }}" {{ $member->committee_id == $committee->id ? 'selected' : '' }}>
                        {{ $committee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Member Full Name *</label>
            <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Mobile Number</label>
                <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Monthly Donation Pledge (₹) *</label>
            <input type="number" step="0.01" name="monthly_pledge_amount" value="{{ old('monthly_pledge_amount', $member->monthly_pledge_amount) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Status *</label>
            <select name="status" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
                <option value="active" {{ $member->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $member->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Address</label>
            <textarea name="address" rows="2" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">{{ old('address', $member->address) }}</textarea>
        </div>

        <div class="pt-4 flex items-center justify-between">
            <button type="button" onclick="if(confirm('Delete member?')) document.getElementById('deleteMemberForm').submit();" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">
                <i class="fa-solid fa-trash mr-1"></i> Delete Member
            </button>
            <div class="flex items-center space-x-3">
                <a href="{{ route('members.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-sm font-semibold hover:bg-slate-700 transition">Cancel</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition">Update Member</button>
            </div>
        </div>
    </form>

    <form id="deleteMemberForm" action="{{ route('members.destroy', $member->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
