@extends('layouts.app')

@section('title', 'Committee Expenses | ComDonation')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Expenses Log</h2>
            <p class="text-slate-400 text-sm">Track committee disbursements, maintenance costs, and welfare spending.</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="px-4 py-2.5 rounded-xl bg-rose-500 text-white text-sm font-bold shadow-lg shadow-rose-500/20 hover:bg-rose-600 transition flex items-center justify-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Log Expense</span>
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('expenses.index') }}" class="glass-card p-4 rounded-2xl grid grid-cols-1 sm:grid-cols-3 gap-3 items-center">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or description..." class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-rose-500">
        </div>
        <div>
            <select name="committee_id" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-rose-500">
                <option value="">All Committees</option>
                @foreach($committees as $comm)
                    <option value="{{ $comm->id }}" {{ request('committee_id') == $comm->id ? 'selected' : '' }}>{{ $comm->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="category" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-rose-500">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Total Banner -->
    <div class="glass-card p-4 rounded-xl flex items-center justify-between">
        <span class="text-xs font-semibold text-slate-400">Total Filtered Expenses:</span>
        <span class="text-lg font-black text-rose-400">₹{{ number_format($totalExpenseAmount, 2) }}</span>
    </div>

    <!-- Expenses Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="p-4">Title / Purpose</th>
                        <th class="p-4">Committee</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Approved By</th>
                        <th class="p-4 text-right">Amount</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="p-4">
                                <div class="font-bold text-white text-sm">{{ $expense->title }}</div>
                                <div class="text-slate-400 text-[11px]">{{ $expense->description ?: 'No notes' }}</div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-800 text-slate-300">
                                    {{ $expense->committee ? $expense->committee->name : 'N/A' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    {{ $expense->category }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-300">
                                {{ $expense->expense_date->format('d M Y') }}
                            </td>
                            <td class="p-4 text-slate-400">
                                {{ $expense->approved_by ?: 'System Admin' }}
                            </td>
                            <td class="p-4 font-black text-sm text-rose-400 text-right">
                                -₹{{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="p-4 text-right">
                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Delete expense entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-rose-400 hover:bg-rose-500/10 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">No expense records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $expenses->links() }}
        </div>
    </div>
</div>
@endsection
