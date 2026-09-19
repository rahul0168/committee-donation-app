<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function index()
    {
        $committees = Committee::withCount(['members', 'donations', 'expenses'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('committees.index', compact('committees'));
    }

    public function create()
    {
        return view('committees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,paused',
        ]);

        Committee::create($validated);

        return redirect()->route('committees.index')->with('success', 'Committee created successfully.');
    }

    public function show(Committee $committee)
    {
        $committee->load(['members', 'donations' => function($q) {
            $q->orderBy('payment_date', 'desc')->take(10);
        }, 'expenses' => function($q) {
            $q->orderBy('expense_date', 'desc')->take(10);
        }]);

        return view('committees.show', compact('committee'));
    }

    public function edit(Committee $committee)
    {
        return view('committees.edit', compact('committee'));
    }

    public function update(Request $request, Committee $committee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,completed,paused',
        ]);

        $committee->update($validated);

        return redirect()->route('committees.index')->with('success', 'Committee updated successfully.');
    }

    public function destroy(Committee $committee)
    {
        $committee->delete();
        return redirect()->route('committees.index')->with('success', 'Committee deleted successfully.');
    }
}
