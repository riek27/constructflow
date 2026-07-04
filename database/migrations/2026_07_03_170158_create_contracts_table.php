<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('contract_number')->unique();
            $table->decimal('contract_value', 15, 2)->nullable();
            $table->string('currency')->default('USD');
            $table->string('client')->nullable();
            $table->date('start_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->decimal('retention_percent', 5, 2)->nullable();
            $table->integer('defects_liability_months')->nullable();
            $table->text('payment_terms')->nullable();
            $table->text('scope_summary')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
}