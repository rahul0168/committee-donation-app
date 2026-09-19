@extends('layouts.app')

@section('title', $committee->name . ' | ComDonation')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    {{ $committee->status }}
                </span>
                <span class="text-xs text-slate-400">Created {{ $committee->created_at->format('M Y') }}</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-white mt-1">{{ $committee->name }}</h2>
            <p class="text-slate-400 text-sm mt-1">{{ $committee->description }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('donations.create') }}?committee_id={{ $committee->id }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 text-white text-xs font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition flex items-center space-x-2">
                <i class="fa-solid fa-plus"></i>
                <span>Add Donation</span>
            </a>
            <a href="{{ route('committees.edit', $committee->id) }}" class="px-3.5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-xs font-semibold hover:bg-slate-700 transition">
                <i class="fa-solid fa-gear"></i>
            </a>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-card p-4 rounded-xl">
            <span class="text-xs text-slate-400 font-semibold uppercase">Target Budget</span>
            <div class="text-xl font-black text-white mt-1">₹{{ number_format($committee->target_amount, 2) }}</div>
        </div>
        <div class="glass-card p-4 rounded-xl">
            <span class="text-xs text-slate-400 font-semibold uppercase">Total Collected</span>
            <div class="text-xl font-black text-emerald-400 mt-1">₹{{ number_format($committee->total_collected, 2) }}</div>
        </div>
        <div class="glass-card p-4 rounded-xl">
            <span class="text-xs text-slate-400 font-semibold uppercase">Total Expenses</span>
            <div class="text-xl font-black text-rose-400 mt-1">₹{{ number_format($committee->total_expenses, 2) }}</div>
        </div>
        <div class="glass-card p-4 rounded-xl">
            <span class="text-xs text-slate-400 font-semibold uppercase">Net Balance</span>
            <div class="text-xl font-black text-teal-400 mt-1">₹{{ number_format($committee->net_balance, 2) }}</div>
        </div>
    </div>

    <!-- Progress -->
    <div class="glass-card p-5 rounded-2xl space-y-2">
        <div class="flex justify-between items-center text-sm">
            <span class="font-bold text-white">Target Achievement Progress</span>
            <span class="font-black text-emerald-400">{{ $committee->progress_percentage }}%</span>
        </div>
        <div class="w-full bg-slate-800 h-3 rounded-full overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-3 rounded-full transition-all duration-500" style="width: {{ $committee->progress_percentage }}%"></div>
        </div>
    </div>

    <!-- Tabs / Sections: Members & Donations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Committee Members -->
        <div class="glass-card p-5 rounded-2xl space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-base text-white flex items-center space-x-2">
                    <i class="fa-solid fa-users text-emerald-400"></i>
                    <span>Committee Members ({{ $committee->members->count() }})</span>
                </h3>
                <a href="{{ route('members.create') }}?committee_id={{ $committee->id }}" class="text-xs font-semibold text-emerald-400 hover:underline">+ Add Member</a>
            </div>

            <div class="space-y-3">
                @forelse($committee->members as $member)
                    <div class="flex items-center justify-between bg-slate-900/60 p-3.5 rounded-xl border border-slate-800">
                        <div>
                            <h4 class="font-semibold text-sm text-white">{{ $member->name }}</h4>
                            <p class="text-xs text-slate-400">{{ $member->phone ?: 'No phone' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-slate-200">Pledge: ₹{{ number_format($member->monthly_pledge_amount, 2) }}/mo</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">No members assigned to this committee.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="glass-card p-5 rounded-2xl space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-base text-white flex items-center space-x-2">
                    <i class="fa-solid fa-receipt text-teal-400"></i>
                    <span>Recent Donations</span>
                </h3>
                <a href="{{ route('donations.index') }}?committee_id={{ $committee->id }}" class="text-xs font-semibold text-emerald-400 hover:underline">View All</a>
            </div>

            <div class="space-y-3">
                @forelse($committee->donations as $donation)
                    <div class="flex items-center justify-between bg-slate-900/60 p-3.5 rounded-xl border border-slate-800">
                        <div>
                            <h4 class="font-semibold text-sm text-white">{{ $donation->donor_name }}</h4>
                            <p class="text-xs text-slate-400">{{ $donation->receipt_number }} • {{ $donation->payment_date->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="font-black text-sm text-emerald-400">+₹{{ number_format($donation->amount, 2) }}</span>
                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ $donation->payment_method }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">No donations recorded for this committee yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
