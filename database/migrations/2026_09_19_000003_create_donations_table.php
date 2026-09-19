<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->foreignId('committee_id')->constrained('committees')->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->string('donor_name');
            $table->string('donor_phone')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('cash'); // cash, upi, bank_transfer, cheque
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
