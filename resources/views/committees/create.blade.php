@extends('layouts.app')

@section('title', 'Create Committee | ComDonation')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Create New Committee</h2>
            <p class="text-slate-400 text-sm">Add a new fund drive, welfare project, or committee.</p>
        </div>
        <a href="{{ route('committees.index') }}" class="text-slate-400 hover:text-white text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <form action="{{ route('committees.store') }}" method="POST" class="glass-card p-6 rounded-2xl space-y-5">
        @csrf

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Committee Name *</label>
            <input type="text" name="name" required placeholder="e.g. Welfare Fund 2026, Solar Drive" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm">
            @error('name') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Target Amount (₹) *</label>
            <input type="number" step="0.01" name="target_amount" required placeholder="e.g. 100000" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm">
            @error('target_amount') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Status *</label>
            <select name="status" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="paused">Paused</option>
            </select>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Description / Purpose</label>
            <textarea name="description" rows="3" placeholder="Specify objective of this committee..." class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 text-sm"></textarea>
        </div>

        <div class="pt-4 flex items-center justify-end space-x-3">
            <a href="{{ route('committees.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-sm font-semibold hover:bg-slate-700 transition">Cancel</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition">Save Committee</button>
        </div>
    </form>
</div>
@endsection
