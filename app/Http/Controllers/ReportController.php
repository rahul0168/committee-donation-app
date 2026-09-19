<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Donation;
use App\Models\Expense;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date', date('Y-m-01'));
        $toDate = $request->input('to_date', date('Y-m-t'));
        $committeeId = $request->input('committee_id');

        $donationsQuery = Donation::whereBetween('payment_date', [$fromDate, $toDate]);
        $expensesQuery = Expense::whereBetween('expense_date', [$fromDate, $toDate]);

        if ($committeeId) {
            $donationsQuery->where('committee_id', $committeeId);
            $expensesQuery->where('committee_id', $committeeId);
        }

        $donations = $donationsQuery->with('committee')->get();
        $expenses = $expensesQuery->with('committee')->get();

        $totalIncome = $donations->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        $committees = Committee::all();

        return view('reports.index', compact(
            'donations',
            'expenses',
            'totalIncome',
            'totalExpense',
            'netBalance',
            'fromDate',
            'toDate',
            'committeeId',
            'committees'
        ));
    }

    public function exportCsv(Request $request)
    {
        $fromDate = $request->input('from_date', date('Y-m-01'));
        $toDate = $request->input('to_date', date('Y-m-t'));
        $committeeId = $request->input('committee_id');

        $query = Donation::whereBetween('payment_date', [$fromDate, $toDate]);
        if ($committeeId) {
            $query->where('committee_id', $committeeId);
        }

        $donations = $query->with('committee')->get();

        $filename = "donation_report_{$fromDate}_to_{$toDate}.csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($donations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Receipt No', 'Date', 'Committee', 'Donor Name', 'Phone', 'Amount', 'Payment Method', 'Notes']);

            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->receipt_number,
                    $donation->payment_date->format('Y-m-d'),
                    $donation->committee ? $donation->committee->name : 'N/A',
                    $donation->donor_name,
                    $donation->donor_phone ?? '',
                    $donation->amount,
                    strtoupper($donation->payment_method),
                    $donation->notes ?? ''
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
