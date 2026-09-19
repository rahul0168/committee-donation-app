@extends('layouts.app')

@section('title', 'Edit Committee | ComDonation')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Edit Committee</h2>
            <p class="text-slate-400 text-sm">Update committee target budget or status.</p>
        </div>
        <a href="{{ route('committees.index') }}" class="text-slate-400 hover:text-white text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <form action="{{ route('committees.update', $committee->id) }}" method="POST" class="glass-card p-6 rounded-2xl space-y-5">
        @csrf
        @method('PUT')

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Committee Name *</label>
            <input type="text" name="name" value="{{ old('name', $committee->name) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
            @error('name') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Target Amount (₹) *</label>
            <input type="number" step="0.01" name="target_amount" value="{{ old('target_amount', $committee->target_amount) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
            @error('target_amount') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Status *</label>
            <select name="status" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">
                <option value="active" {{ $committee->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ $committee->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="paused" {{ $committee->status === 'paused' ? 'selected' : '' }}>Paused</option>
            </select>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Description / Purpose</label>
            <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-emerald-500 text-sm">{{ old('description', $committee->description) }}</textarea>
        </div>

        <div class="pt-4 flex items-center justify-between">
            <button type="button" onclick="if(confirm('Delete this committee?')) document.getElementById('deleteForm').submit();" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">
                <i class="fa-solid fa-trash mr-1"></i> Delete Committee
            </button>
            <div class="flex items-center space-x-3">
                <a href="{{ route('committees.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-sm font-semibold hover:bg-slate-700 transition">Cancel</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition">Update Committee</button>
            </div>
        </div>
    </form>

    <form id="deleteForm" action="{{ route('committees.destroy', $committee->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
