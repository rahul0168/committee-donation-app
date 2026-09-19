@extends('layouts.app')

@section('title', 'Donations Log | ComDonation')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Donations Register</h2>
            <p class="text-slate-400 text-sm">View, filter, and print donation receipts.</p>
        </div>
        <a href="{{ route('donations.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition flex items-center justify-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Record New Donation</span>
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('donations.index') }}" class="glass-card p-4 rounded-2xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 items-center">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Donor name, receipt #, phone..." class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500">
        </div>
        <div>
            <select name="committee_id" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500">
                <option value="">All Committees</option>
                @foreach($committees as $comm)
                    <option value="{{ $comm->id }}" {{ request('committee_id') == $comm->id ? 'selected' : '' }}>{{ $comm->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="payment_method" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500">
                <option value="">All Payment Methods</option>
                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="upi" {{ request('payment_method') == 'upi' ? 'selected' : '' }}>UPI / Online</option>
                <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="cheque" {{ request('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
            </select>
        </div>
        <div class="flex items-center space-x-2">
            <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 text-slate-200 text-xs font-semibold hover:bg-slate-700 transition">Search</button>
            <a href="{{ route('donations.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 text-xs hover:text-white">Reset</a>
        </div>
    </form>

    <!-- Summary Box -->
    <div class="glass-card p-4 rounded-xl flex items-center justify-between">
        <span class="text-xs font-semibold text-slate-400">Total Filtered Collections:</span>
        <span class="text-lg font-black text-emerald-400">₹{{ number_format($totalCollected, 2) }}</span>
    </div>

    <!-- Donations Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="p-4">Receipt #</th>
                        <th class="p-4">Donor Name</th>
                        <th class="p-4">Committee</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Method</th>
                        <th class="p-4 text-right">Receipt</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    @forelse($donations as $donation)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="p-4 font-mono text-emerald-400 font-bold">
                                {{ $donation->receipt_number }}
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-white text-sm">{{ $donation->donor_name }}</div>
                                @if($donation->donor_phone)
                                    <div class="text-slate-400 text-[11px]"><i class="fa-solid fa-phone text-[9px] mr-1"></i>{{ $donation->donor_phone }}</div>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-800 text-slate-300">
                                    {{ $donation->committee ? $donation->committee->name : 'General' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-300">
                                {{ $donation->payment_date->format('d M Y') }}
                            </td>
                            <td class="p-4 font-black text-sm text-emerald-400">
                                ₹{{ number_format($donation->amount, 2) }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $donation->payment_method === 'upi' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : '' }}
                                    {{ $donation->payment_method === 'cash' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : '' }}
                                    {{ $donation->payment_method === 'bank_transfer' ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : '' }}
                                    {{ $donation->payment_method === 'cheque' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : '' }}">
                                    {{ $donation->payment_method }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('donations.receipt', $donation->id) }}" class="px-3 py-1.5 rounded-lg bg-emerald-500 text-white font-semibold text-xs shadow-md shadow-emerald-500/20 hover:bg-emerald-600 transition inline-flex items-center space-x-1">
                                    <i class="fa-solid fa-print"></i>
                                    <span>Receipt</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">No donation records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $donations->links() }}
        </div>
    </div>
</div>
@endsection
