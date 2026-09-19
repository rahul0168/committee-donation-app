@extends('layouts.app')

@section('title', 'Committees | ComDonation')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Committees & Programs</h2>
            <p class="text-slate-400 text-sm">Manage donation funds, target budgets, and committee details.</p>
        </div>
        <a href="{{ route('committees.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition flex items-center justify-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Create Committee</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($committees as $committee)
            <div class="glass-card p-6 rounded-2xl flex flex-col justify-between space-y-4 hover:border-slate-700 transition">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold uppercase tracking-wider {{ $committee->status === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-400' }}">
                            {{ $committee->status }}
                        </span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('committees.edit', $committee->id) }}" class="text-slate-400 hover:text-white text-xs p-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                    </div>
                    <h3 class="text-lg font-extrabold text-white">
                        <a href="{{ route('committees.show', $committee->id) }}" class="hover:text-emerald-400 transition">
                            {{ $committee->name }}
                        </a>
                    </h3>
                    <p class="text-xs text-slate-400 line-clamp-2">{{ $committee->description ?: 'No description provided.' }}</p>
                </div>

                <div class="space-y-3 pt-2 border-t border-slate-800">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400">Target Budget:</span>
                        <span class="font-bold text-white">₹{{ number_format($committee->target_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400">Collected Fund:</span>
                        <span class="font-black text-emerald-400">₹{{ number_format($committee->total_collected, 2) }}</span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-2 rounded-full" style="width: {{ $committee->progress_percentage }}%"></div>
                    </div>

                    <div class="flex justify-between text-[11px] text-slate-400 pt-1">
                        <span><i class="fa-solid fa-users mr-1"></i> {{ $committee->members_count }} Members</span>
                        <span><i class="fa-solid fa-receipt mr-1"></i> {{ $committee->donations_count }} Donations</span>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('committees.show', $committee->id) }}" class="w-full py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs text-slate-200 font-semibold flex items-center justify-center space-x-2 transition">
                        <span>Manage & View Details</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full glass-card p-12 text-center text-slate-500 rounded-2xl">
                <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-600"></i>
                <p class="font-medium text-sm">No committees registered yet.</p>
                <a href="{{ route('committees.create') }}" class="inline-block mt-4 px-4 py-2 bg-emerald-500 text-white text-xs font-bold rounded-xl">Create First Committee</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
