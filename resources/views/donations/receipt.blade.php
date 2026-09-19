@extends('layouts.app')

@section('title', 'Receipt ' . $donation->receipt_number . ' | ComDonation')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <div class="flex items-center justify-between no-print">
        <a href="{{ route('donations.index') }}" class="text-slate-400 hover:text-white text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Donations
        </a>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-3.5 py-2 rounded-xl bg-slate-800 text-slate-200 text-xs font-semibold hover:bg-slate-700 transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>Print Receipt</span>
            </button>
            @php
                $waText = rawurlencode("✨ *DONATION RECEIPT* ✨\n\n*Receipt No:* {$donation->receipt_number}\n*Committee:* " . ($donation->committee ? $donation->committee->name : 'General') . "\n*Donor Name:* {$donation->donor_name}\n*Amount Received:* ₹" . number_format($donation->amount, 2) . "\n*Payment Method:* " . strtoupper($donation->payment_method) . "\n*Date:* " . $donation->payment_date->format('d M Y') . "\n\nThank you for your generous contribution!");
                $waLink = $donation->donor_phone ? "https://wa.me/" . preg_replace('/[^0-9]/', '', $donation->donor_phone) . "?text={$waText}" : "https://wa.me/?text={$waText}";
            @endphp
            <a href="{{ $waLink }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-500 transition flex items-center space-x-1.5 shadow-lg shadow-emerald-600/20">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Share WhatsApp</span>
            </a>
        </div>
    </div>

    <!-- Printable Receipt Card -->
    <div id="receiptCard" class="bg-slate-900 border-2 border-slate-700 rounded-3xl p-6 md:p-8 space-y-6 shadow-2xl relative overflow-hidden">
        <!-- Watermark background decoration -->
        <div class="absolute -right-12 -bottom-12 text-slate-800/40 text-9xl pointer-events-none">
            <i class="fa-solid fa-hand-holding-heart"></i>
        </div>

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-800 pb-5">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-emerald-500/30">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-lg text-white">ComDonation</h3>
                    <p class="text-xs text-slate-400">Official Donation Voucher</p>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-xs font-mono font-extrabold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                    PAID
                </span>
                <div class="text-[11px] font-mono text-slate-400 mt-1">#{{ $donation->receipt_number }}</div>
            </div>
        </div>

        <!-- Amount Banner -->
        <div class="bg-gradient-to-r from-slate-950 via-emerald-950/40 to-slate-950 p-6 rounded-2xl border border-emerald-500/20 text-center space-y-1">
            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Amount Received</div>
            <div class="text-3xl md:text-4xl font-black text-emerald-400">₹{{ number_format($donation->amount, 2) }}</div>
            <div class="text-xs text-slate-400 pt-1">
                Payment via <strong class="text-white uppercase">{{ $donation->payment_method }}</strong> on {{ $donation->payment_date->format('d M, Y') }}
            </div>
        </div>

        <!-- Donor Details grid -->
        <div class="grid grid-cols-2 gap-4 text-xs pt-2">
            <div class="bg-slate-950/60 p-3.5 rounded-xl border border-slate-800/80">
                <span class="text-slate-400 text-[11px] block">Donor Name</span>
                <strong class="text-sm font-bold text-white block mt-0.5">{{ $donation->donor_name }}</strong>
            </div>

            <div class="bg-slate-950/60 p-3.5 rounded-xl border border-slate-800/80">
                <span class="text-slate-400 text-[11px] block">Committee Fund</span>
                <strong class="text-sm font-bold text-emerald-400 block mt-0.5">{{ $donation->committee ? $donation->committee->name : 'General Fund' }}</strong>
            </div>

            <div class="bg-slate-950/60 p-3.5 rounded-xl border border-slate-800/80">
                <span class="text-slate-400 text-[11px] block">Contact Number</span>
                <strong class="text-slate-200 block mt-0.5">{{ $donation->donor_phone ?: 'Not provided' }}</strong>
            </div>

            <div class="bg-slate-950/60 p-3.5 rounded-xl border border-slate-800/80">
                <span class="text-slate-400 text-[11px] block">Payment Date</span>
                <strong class="text-slate-200 block mt-0.5">{{ $donation->payment_date->format('F d, Y') }}</strong>
            </div>
        </div>

        @if($donation->notes)
            <div class="bg-slate-950/40 p-3.5 rounded-xl border border-slate-800 text-xs">
                <span class="text-slate-400 block text-[11px] mb-1">Notes / Purpose:</span>
                <p class="text-slate-200 italic">{{ $donation->notes }}</p>
            </div>
        @endif

        <!-- Footer Seal -->
        <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-shield-halved text-emerald-400 text-base"></i>
                <span>Verified Committee Entry</span>
            </div>
            <span>Authorized Signature</span>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .no-print {
        display: none !important;
    }
    #receiptCard, #receiptCard * {
        visibility: visible;
    }
    #receiptCard {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        color: black !important;
        background: white !important;
        border: 2px solid black !important;
    }
    #receiptCard * {
        color: black !important;
    }
}
</style>
@endsection
