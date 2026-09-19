@extends('layouts.app')

@section('title', 'Dashboard | Committee Donation Manager')

@section('content')
<div class="space-y-6">

    <!-- Top Welcome Banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 glass-card p-6 rounded-2xl bg-gradient-to-r from-slate-900 via-slate-900 to-emerald-950/40">
        <div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 mb-2">
                <i class="fa-solid fa-mobile-screen-button mr-1.5"></i> Android PWA Ready
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Committee Overview</h2>
            <p class="text-slate-400 text-sm mt-1">Real-time donation metrics, member pledges & expenditure tracking.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('donations.create') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 hover:from-emerald-600 hover:to-teal-600 transition flex items-center space-x-2">
                <i class="fa-solid fa-plus"></i>
                <span>Record Donation</span>
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Collected -->
        <div class="glass-card p-5 rounded-2xl relative overflow-hidden">
            <div class="flex items-center justify-between text-slate-400 text-xs font-semibold uppercase tracking-wider">
                <span>Total Collected</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-wallet"></i>
                </span>
            </div>
            <div class="mt-3">
                <span class="text-xl md:text-3xl font-black text-white">₹{{ number_format($totalDonations, 2) }}</span>
            </div>
            <div class="mt-2 text-xs text-emerald-400 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span>All committees combined</span>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="glass-card p-5 rounded-2xl relative overflow-hidden">
            <div class="flex items-center justify-between text-slate-400 text-xs font-semibold uppercase tracking-wider">
                <span>Total Expenses</span>
                <span class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </span>
            </div>
            <div class="mt-3">
                <span class="text-xl md:text-3xl font-black text-white">₹{{ number_format($totalExpenses, 2) }}</span>
            </div>
            <div class="mt-2 text-xs text-rose-400 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-trend-down"></i>
                <span>Approved disbursements</span>
            </div>
        </div>

        <!-- Net Balance -->
        <div class="glass-card p-5 rounded-2xl relative overflow-hidden">
            <div class="flex items-center justify-between text-slate-400 text-xs font-semibold uppercase tracking-wider">
                <span>Net Fund Balance</span>
                <span class="w-8 h-8 rounded-lg bg-teal-500/10 text-teal-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-vault"></i>
                </span>
            </div>
            <div class="mt-3">
                <span class="text-xl md:text-3xl font-black {{ $netBalance >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                    ₹{{ number_format($netBalance, 2) }}
                </span>
            </div>
            <div class="mt-2 text-xs text-slate-400">Available reserve</div>
        </div>

        <!-- Active Donors / Members -->
        <div class="glass-card p-5 rounded-2xl relative overflow-hidden">
            <div class="flex items-center justify-between text-slate-400 text-xs font-semibold uppercase tracking-wider">
                <span>Active Members</span>
                <span class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-users"></i>
                </span>
            </div>
            <div class="mt-3">
                <span class="text-xl md:text-3xl font-black text-white">{{ $totalMembers }}</span>
            </div>
            <div class="mt-2 text-xs text-slate-400">{{ $totalCommittees }} Active Committees</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Financial Trend Chart -->
        <div class="lg:col-span-2 glass-card p-5 rounded-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-base text-white flex items-center space-x-2">
                    <i class="fa-solid fa-chart-line text-emerald-400"></i>
                    <span>Monthly Financial Flow (6 Months)</span>
                </h3>
            </div>
            <div class="h-64">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Payment Method Breakdown Chart -->
        <div class="glass-card p-5 rounded-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-base text-white flex items-center space-x-2">
                    <i class="fa-solid fa-chart-pie text-teal-400"></i>
                    <span>Payment Methods</span>
                </h3>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Active Committees Target Progress & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Committee Target Progress -->
        <div class="glass-card p-5 rounded-2xl space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-base text-white flex items-center space-x-2">
                    <i class="fa-solid fa-bullseye text-emerald-400"></i>
                    <span>Committee Collection Progress</span>
                </h3>
                <a href="{{ route('committees.index') }}" class="text-xs font-semibold text-emerald-400 hover:underline">View All</a>
            </div>

            <div class="space-y-4 pt-2">
                @foreach($committees as $committee)
                    @php
                        $collected = $committee->total_collected;
                        $target = $committee->target_amount;
                        $percentage = $committee->progress_percentage;
                    @endphp
                    <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800 space-y-2">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('committees.show', $committee->id) }}" class="font-bold text-sm text-white hover:text-emerald-400 transition">
                                {{ $committee->name }}
                            </a>
                            <span class="text-xs font-extrabold px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                {{ $percentage }}%
                            </span>
                        </div>
                        <div class="w-full bg-slate-800 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-slate-400 pt-1">
                            <span>Collected: <strong class="text-slate-200">₹{{ number_format($collected, 2) }}</strong></span>
                            <span>Target: <strong class="text-slate-200">₹{{ number_format($target, 2) }}</strong></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="glass-card p-5 rounded-2xl space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-base text-white flex items-center space-x-2">
                    <i class="fa-solid fa-clock-rotate-left text-indigo-400"></i>
                    <span>Recent Donations</span>
                </h3>
                <a href="{{ route('donations.index') }}" class="text-xs font-semibold text-emerald-400 hover:underline">View All</a>
            </div>

            <div class="space-y-3 pt-2">
                @forelse($recentDonations as $donation)
                    <div class="flex items-center justify-between bg-slate-900/60 p-3.5 rounded-xl border border-slate-800/80 hover:border-slate-700 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-sm">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm text-white">{{ $donation->donor_name }}</h4>
                                <p class="text-xs text-slate-400">{{ $donation->committee ? $donation->committee->name : 'General' }} • {{ $donation->payment_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-black text-sm text-emerald-400">+₹{{ number_format($donation->amount, 2) }}</div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">{{ $donation->payment_method }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">No donations recorded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Trend Chart
        const trendsData = @json($monthlyTrends);
        const labels = trendsData.map(item => item.month);
        const incomes = trendsData.map(item => item.income);
        const expenses = trendsData.map(item => item.expense);

        const ctx1 = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Donations Collected (₹)',
                        data: incomes,
                        backgroundColor: '#10b981',
                        borderRadius: 6
                    },
                    {
                        label: 'Expenses (₹)',
                        data: expenses,
                        backgroundColor: '#f43f5e',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#94a3b8' } }
                },
                scales: {
                    x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
                    y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255, 255, 255, 0.05)' } }
                }
            }
        });

        // Payment Methods Pie Chart
        const methodData = @json($paymentMethods);
        const methodLabels = Object.keys(methodData).map(k => k.toUpperCase().replace('_', ' '));
        const methodValues = Object.values(methodData);

        const ctx2 = document.getElementById('paymentChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: methodLabels,
                datasets: [{
                    data: methodValues,
                    backgroundColor: ['#10b981', '#06b6d4', '#6366f1', '#f59e0b'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#94a3b8', font: { size: 11 } } }
                }
            }
        });
    });
</script>
@endpush
