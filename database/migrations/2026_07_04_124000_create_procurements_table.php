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
    Schema::create('procurements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained()->cascadeOnDelete();
        $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
        $table->string('po_number')->unique();                     // Purchase Order number
        $table->text('description')->nullable();                  // item / scope
        $table->decimal('quantity', 10, 2)->nullable();
        $table->string('unit')->nullable();                       // e.g., pcs, m2, lot
        $table->decimal('unit_cost', 15, 2)->nullable();
        $table->decimal('total_cost', 15, 2)->nullable();         // calculated
        $table->date('order_date')->nullable();
        $table->date('delivery_date')->nullable();
        $table->string('status')->default('requested');           // requested, approved, ordered, delivered, closed
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurements');
    }
};
