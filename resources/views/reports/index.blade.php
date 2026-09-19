@extends('layouts.app')

@section('title', 'Financial Reports | ComDonation')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Financial Statement & Audit Report</h2>
            <p class="text-slate-400 text-sm">Generate monthly statement, income vs expenditure report, & export CSV.</p>
        </div>
        <a href="{{ route('reports.export-csv') }}?from_date={{ $fromDate }}&to_date={{ $toDate }}&committee_id={{ $committeeId }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-sm font-semibold border border-slate-700 transition flex items-center justify-center space-x-2">
            <i class="fa-solid fa-file-csv text-emerald-400 text-base"></i>
            <span>Export CSV Report</span>
        </a>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('reports.index') }}" class="glass-card p-4 rounded-2xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 items-end">
        <div class="space-y-1">
            <label class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">From Date</label>
            <input type="date" name="from_date" value="{{ $fromDate }}" class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500">
        </div>
        <div class="space-y-1">
            <label class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">To Date</label>
            <input type="date" name="to_date" value="{{ $toDate }}" class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500">
        </div>
        <div class="space-y-1">
            <label class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Committee</label>
            <select name="committee_id" class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500">
                <option value="">All Committees</option>
                @foreach($committees as $comm)
                    <option value="{{ $comm->id }}" {{ $committeeId == $comm->id ? 'selected' : '' }}>{{ $comm->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-emerald-500 text-white text-xs font-bold shadow-md shadow-emerald-500/20 hover:bg-emerald-600 transition">
                Generate Report
            </button>
        </div>
    </form>

    <!-- Summary Box -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="glass-card p-5 rounded-2xl border border-emerald-500/30 bg-emerald-950/20">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Period Income</span>
            <div class="text-2xl font-black text-emerald-400 mt-2">₹{{ number_format($totalIncome, 2) }}</div>
            <div class="text-[11px] text-slate-400 mt-1">{{ count($donations) }} Donation entries</div>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-rose-500/30 bg-rose-950/20">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Period Expenditure</span>
            <div class="text-2xl font-black text-rose-400 mt-2">₹{{ number_format($totalExpense, 2) }}</div>
            <div class="text-[11px] text-slate-400 mt-1">{{ count($expenses) }} Expense entries</div>
        </div>

        <div class="glass-card p-5 rounded-2xl border border-teal-500/30 bg-teal-950/20">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Net Period Surplus</span>
            <div class="text-2xl font-black {{ $netBalance >= 0 ? 'text-teal-400' : 'text-rose-400' }} mt-2">
                ₹{{ number_format($netBalance, 2) }}
            </div>
            <div class="text-[11px] text-slate-400 mt-1">Net Cashflow</div>
        </div>
    </div>

    <!-- Income Statement Table -->
    <div class="glass-card p-5 rounded-2xl space-y-4">
        <h3 class="font-extrabold text-base text-white flex items-center space-x-2">
            <i class="fa-solid fa-list-check text-emerald-400"></i>
            <span>Period Income Items (Donations)</span>
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="p-3">Receipt #</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Donor Name</th>
                        <th class="p-3">Committee</th>
                        <th class="p-3">Method</th>
                        <th class="p-3 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    @forelse($donations as $d)
                        <tr>
                            <td class="p-3 font-mono font-bold text-emerald-400">{{ $d->receipt_number }}</td>
                            <td class="p-3 text-slate-300">{{ $d->payment_date->format('d M Y') }}</td>
                            <td class="p-3 font-semibold text-white">{{ $d->donor_name }}</td>
                            <td class="p-3 text-slate-400">{{ $d->committee ? $d->committee->name : 'N/A' }}</td>
                            <td class="p-3 uppercase text-[10px] text-slate-400 font-semibold">{{ $d->payment_method }}</td>
                            <td class="p-3 font-bold text-emerald-400 text-right">+₹{{ number_format($d->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-500">No income recorded for selected period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Expense Statement Table -->
    <div class="glass-card p-5 rounded-2xl space-y-4">
        <h3 class="font-extrabold text-base text-white flex items-center space-x-2">
            <i class="fa-solid fa-receipt text-rose-400"></i>
            <span>Period Expenditure Items</span>
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="p-3">Title</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Category</th>
                        <th class="p-3">Committee</th>
                        <th class="p-3 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    @forelse($expenses as $e)
                        <tr>
                            <td class="p-3 font-semibold text-white">{{ $e->title }}</td>
                            <td class="p-3 text-slate-300">{{ $e->expense_date->format('d M Y') }}</td>
                            <td class="p-3"><span class="px-2 py-0.5 rounded text-[10px] bg-rose-500/10 text-rose-400">{{ $e->category }}</span></td>
                            <td class="p-3 text-slate-400">{{ $e->committee ? $e->committee->name : 'N/A' }}</td>
                            <td class="p-3 font-bold text-rose-400 text-right">-₹{{ number_format($e->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-500">No expenses recorded for selected period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
