<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->string('variation_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('estimated_cost', 15, 2)->nullable();
            $table->decimal('approved_cost', 15, 2)->nullable();
            $table->decimal('quotation_amount', 15, 2)->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variations');
    }
}
