<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Committee;
use App\Models\Member;
use App\Models\Donation;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@committee.org',
        ], [
            'name' => 'Committee Admin',
            'password' => Hash::make('password'),
        ]);

        // 2. Create ONLY ONE primary committee
        $committee = Committee::create([
            'name' => 'Central Welfare Committee Fund',
            'description' => 'Official single committee fund for community welfare, emergency relief, and monthly member pledge collections.',
            'target_amount' => 200000.00,
            'status' => 'active',
        ]);

        // 3. Registered Members for this committee
        $m1 = Member::create([
            'committee_id' => $committee->id,
            'name' => 'Ahmed Khan',
            'phone' => '+91 98765 43210',
            'email' => 'ahmed.khan@example.com',
            'address' => 'House 42, Central Street',
            'monthly_pledge_amount' => 2000.00,
            'status' => 'active',
        ]);

        $m2 = Member::create([
            'committee_id' => $committee->id,
            'name' => 'Fatima Sheikh',
            'phone' => '+91 98123 45678',
            'email' => 'fatima.s@example.com',
            'address' => 'Plot 12, Green Park',
            'monthly_pledge_amount' => 3500.00,
            'status' => 'active',
        ]);

        $m3 = Member::create([
            'committee_id' => $committee->id,
            'name' => 'Dr. Mohammad Bilal',
            'phone' => '+91 97654 32109',
            'email' => 'dr.bilal@example.com',
            'address' => 'Suite 5, City Medical Clinic',
            'monthly_pledge_amount' => 5000.00,
            'status' => 'active',
        ]);

        // 4. Sample Donations for this committee
        Donation::create([
            'receipt_number' => 'REC-202609-0001',
            'committee_id' => $committee->id,
            'member_id' => $m1->id,
            'donor_name' => 'Ahmed Khan',
            'donor_phone' => '+91 98765 43210',
            'amount' => 5000.00,
            'payment_method' => 'upi',
            'payment_date' => Carbon::now()->subDays(10)->toDateString(),
            'notes' => 'September Monthly Contribution',
            'recorded_by' => $admin->id,
        ]);

        Donation::create([
            'receipt_number' => 'REC-202609-0002',
            'committee_id' => $committee->id,
            'member_id' => $m2->id,
            'donor_name' => 'Fatima Sheikh',
            'donor_phone' => '+91 98123 45678',
            'amount' => 10000.00,
            'payment_method' => 'bank_transfer',
            'payment_date' => Carbon::now()->subDays(7)->toDateString(),
            'notes' => 'Emergency Healthcare Contribution',
            'recorded_by' => $admin->id,
        ]);

        Donation::create([
            'receipt_number' => 'REC-202609-0003',
            'committee_id' => $committee->id,
            'member_id' => $m3->id,
            'donor_name' => 'Dr. Mohammad Bilal',
            'donor_phone' => '+91 97654 32109',
            'amount' => 25000.00,
            'payment_method' => 'upi',
            'payment_date' => Carbon::now()->subDays(3)->toDateString(),
            'notes' => 'Special Committee Drive Donation',
            'recorded_by' => $admin->id,
        ]);

        Donation::create([
            'receipt_number' => 'REC-202609-0004',
            'committee_id' => $committee->id,
            'member_id' => null,
            'donor_name' => 'Anonymous Supporter',
            'donor_phone' => null,
            'amount' => 2500.00,
            'payment_method' => 'cash',
            'payment_date' => Carbon::now()->toDateString(),
            'notes' => 'General Cash Donation',
            'recorded_by' => $admin->id,
        ]);

        // 5. Sample Expenses for this committee
        Expense::create([
            'committee_id' => $committee->id,
            'title' => 'Medical Assistance Reimbursement',
            'category' => 'Welfare',
            'amount' => 4500.00,
            'expense_date' => Carbon::now()->subDays(5)->toDateString(),
            'approved_by' => 'Committee Board',
            'description' => 'Prescription aid for family in need.',
        ]);

        Expense::create([
            'committee_id' => $committee->id,
            'title' => 'Hall Maintenance & Wiring Repair',
            'category' => 'Maintenance',
            'amount' => 3200.00,
            'expense_date' => Carbon::now()->subDays(2)->toDateString(),
            'approved_by' => 'Dr. Mohammad Bilal',
            'description' => 'Lighting repair and utility maintenance.',
        ]);
    }
}
