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
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('transaction_type', ['Income', 'Expense']);
            $table->decimal('amount', 12, 2);
            $table->string('source_payee');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('recorded_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};
