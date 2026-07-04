<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('variation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('client_payment');
            $table->string('invoice_number')->unique();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('vat', 5, 2)->nullable()->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}