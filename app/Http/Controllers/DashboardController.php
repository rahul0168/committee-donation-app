<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Donation;
use App\Models\Expense;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonations = Donation::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $netBalance = $totalDonations - $totalExpenses;
        $totalMembers = Member::where('status', 'active')->count();
        $totalCommittees = Committee::where('status', 'active')->count();

        // Recent Donations
        $recentDonations = Donation::with('committee')
            ->orderBy('payment_date', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        // Committees with progress
        $committees = Committee::withCount('members')
            ->orderBy('id', 'asc')
            ->get();

        // Monthly trends (Last 6 months)
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $year = $date->year;
            $month = $date->month;
            $monthName = $date->format('M Y');

            $income = Donation::whereYear('payment_date', $year)
                ->whereMonth('payment_date', $month)
                ->sum('amount');

            $expense = Expense::whereYear('expense_date', $year)
                ->whereMonth('expense_date', $month)
                ->sum('amount');

            $monthlyTrends[] = [
                'month' => $monthName,
                'income' => (float) $income,
                'expense' => (float) $expense,
            ];
        }

        // Payment method breakdown
        $paymentMethods = Donation::select('payment_method', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method')
            ->toArray();

        return view('dashboard', compact(
            'totalDonations',
            'totalExpenses',
            'netBalance',
            'totalMembers',
            'totalCommittees',
            'recentDonations',
            'committees',
            'monthlyTrends',
            'paymentMethods'
        ));
    }
}
