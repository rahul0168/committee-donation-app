<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Donation;
use App\Models\Member;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['committee', 'member']);

        if ($request->filled('committee_id')) {
            $query->where('committee_id', $request->committee_id);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('receipt_number', 'like', "%{$search}%")
                  ->orWhere('donor_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }

        $donations = $query->orderBy('payment_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        $committees = Committee::all();
        $totalCollected = $query->sum('amount');

        return view('donations.index', compact('donations', 'committees', 'totalCollected'));
    }

    public function create()
    {
        $committees = Committee::where('status', 'active')->get();
        $members = Member::where('status', 'active')->get();
        $receiptNumber = Donation::generateReceiptNumber();

        return view('donations.create', compact('committees', 'members', 'receiptNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'member_id' => 'nullable|exists:members,id',
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,upi,bank_transfer,cheque',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['receipt_number'] = Donation::generateReceiptNumber();

        $donation = Donation::create($validated);

        return redirect()->route('donations.receipt', $donation->id)
            ->with('success', 'Donation recorded successfully! Receipt generated.');
    }

    public function show(Donation $donation)
    {
        $donation->load(['committee', 'member']);
        return view('donations.receipt', compact('donation'));
    }

    public function receipt(Donation $donation)
    {
        $donation->load(['committee', 'member']);
        return view('donations.receipt', compact('donation'));
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donations.index')->with('success', 'Donation record deleted.');
    }
}
