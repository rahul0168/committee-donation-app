@extends('layouts.app')

@section('title', 'Log Expense | ComDonation')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Log Committee Expense</h2>
            <p class="text-slate-400 text-sm">Record expenditure or disbursement against a committee fund.</p>
        </div>
        <a href="{{ route('expenses.index') }}" class="text-slate-400 hover:text-white text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <form action="{{ route('expenses.store') }}" method="POST" class="glass-card p-6 rounded-2xl space-y-5">
        @csrf

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Target Committee *</label>
            <select name="committee_id" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-rose-500 text-sm">
                <option value="">-- Choose Committee --</option>
                @foreach($committees as $comm)
                    <option value="{{ $comm->id }}" {{ request('committee_id') == $comm->id ? 'selected' : '' }}>
                        {{ $comm->name }} (Balance: ₹{{ number_format($comm->net_balance, 2) }})
                    </option>
                @endforeach
            </select>
            @error('committee_id') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Expense Title / Purpose *</label>
            <input type="text" name="title" required placeholder="e.g. Electrical Repairs, Welfare Aid for Patient X" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-rose-500 text-sm">
            @error('title') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Category *</label>
                <select name="category" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-rose-500 text-sm">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Amount (₹) *</label>
                <input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white font-bold text-rose-400 focus:outline-none focus:border-rose-500 text-sm">
                @error('amount') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Date *</label>
                <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:border-rose-500 text-sm">
            </div>
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Approved By</label>
            <input type="text" name="approved_by" placeholder="e.g. Committee Chairman, Board Resolution #4" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-rose-500 text-sm">
        </div>

        <div class="space-y-1">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Description / Notes</label>
            <textarea name="description" rows="2" placeholder="Details about bill receipt or justification..." class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-rose-500 text-sm"></textarea>
        </div>

        <div class="pt-4 flex items-center justify-end space-x-3">
            <a href="{{ route('expenses.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-sm font-semibold hover:bg-slate-700 transition">Cancel</a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-500 text-white text-sm font-bold shadow-lg shadow-rose-500/20 hover:bg-rose-600 transition">Save Expense</button>
        </div>
    </form>
</div>
@endsection
