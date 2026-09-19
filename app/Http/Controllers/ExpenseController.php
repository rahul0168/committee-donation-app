<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('committee');

        if ($request->filled('committee_id')) {
            $query->where('committee_id', $request->committee_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('approved_by', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $expenses = $query->orderBy('expense_date', 'desc')->paginate(15);
        $committees = Committee::all();
        $categories = ['General', 'Welfare', 'Maintenance', 'Refreshment', 'Event', 'Printing', 'Utilities', 'Other'];
        $totalExpenseAmount = $query->sum('amount');

        return view('expenses.index', compact('expenses', 'committees', 'categories', 'totalExpenseAmount'));
    }

    public function create()
    {
        $committees = Committee::where('status', 'active')->get();
        $categories = ['General', 'Welfare', 'Maintenance', 'Refreshment', 'Event', 'Printing', 'Utilities', 'Other'];
        return view('expenses.create', compact('committees', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'approved_by' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense record deleted.');
    }
}
