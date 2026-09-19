@extends('layouts.app')

@section('title', 'Committee Members | ComDonation')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Committee Members</h2>
            <p class="text-slate-400 text-sm">Register members and manage monthly donation pledges.</p>
        </div>
        <a href="{{ route('members.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition flex items-center justify-center space-x-2">
            <i class="fa-solid fa-user-plus"></i>
            <span>Add Member</span>
        </a>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('members.index') }}" class="glass-card p-4 rounded-2xl flex flex-col md:flex-row gap-3 items-center">
        <div class="relative flex-1 w-full">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-500 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, phone, or email..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500">
        </div>
        <div class="w-full md:w-64">
            <select name="committee_id" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500">
                <option value="">All Committees</option>
                @foreach($committees as $comm)
                    <option value="{{ $comm->id }}" {{ request('committee_id') == $comm->id ? 'selected' : '' }}>{{ $comm->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="w-full md:w-auto px-4 py-2.5 rounded-xl bg-slate-800 text-slate-200 text-xs font-semibold hover:bg-slate-700 transition">Filter</button>
    </form>

    <!-- Members Table / Cards -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="p-4">Member</th>
                        <th class="p-4">Committee</th>
                        <th class="p-4">Contact</th>
                        <th class="p-4">Monthly Pledge</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    @forelse($members as $member)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="p-4">
                                <div class="font-bold text-white text-sm">{{ $member->name }}</div>
                                <div class="text-slate-400 text-[11px]">{{ $member->address ?: 'No address specified' }}</div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                    {{ $member->committee ? $member->committee->name : 'Unassigned' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-300">
                                <div><i class="fa-solid fa-phone text-[10px] text-slate-500 mr-1"></i> {{ $member->phone ?: 'N/A' }}</div>
                                @if($member->email)
                                    <div class="text-[11px] text-slate-400"><i class="fa-solid fa-envelope text-[10px] text-slate-500 mr-1"></i> {{ $member->email }}</div>
                                @endif
                            </td>
                            <td class="p-4 font-black text-emerald-400">
                                ₹{{ number_format($member->monthly_pledge_amount, 2) }} <span class="text-[10px] font-normal text-slate-400">/mo</span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('donations.create') }}?member_id={{ $member->id }}&committee_id={{ $member->committee_id }}&donor_name={{ urlencode($member->name) }}&donor_phone={{ urlencode($member->phone) }}" class="px-2.5 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 font-semibold border border-emerald-500/20 transition">
                                    <i class="fa-solid fa-receipt mr-1"></i> Record
                                </a>
                                <a href="{{ route('members.edit', $member->id) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">No members found matching criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection
