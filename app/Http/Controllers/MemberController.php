<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('committee');

        if ($request->filled('committee_id')) {
            $query->where('committee_id', $request->committee_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('name', 'asc')->paginate(15);
        $committees = Committee::where('status', 'active')->get();

        return view('members.index', compact('members', 'committees'));
    }

    public function create()
    {
        $committees = Committee::where('status', 'active')->get();
        return view('members.create', compact('committees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'monthly_pledge_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Committee member registered successfully.');
    }

    public function show(Member $member)
    {
        $member->load(['committee', 'donations' => function($q) {
            $q->orderBy('payment_date', 'desc');
        }]);

        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $committees = Committee::where('status', 'active')->get();
        return view('members.edit', compact('member', 'committees'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'monthly_pledge_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Member details updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
