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
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained()->cascadeOnDelete();
        $table->nullableMorphs('documentable');   // links to any module (Contract, Variation, Payment, Procurement, etc.)
        $table->string('title');
        $table->string('category')->default('Other'); // Contracts, Drawings, Variations, Invoices, Purchase Orders, Photos, Letters, Reports, Other
        $table->string('file_path');                 // stored path
        $table->string('original_name');             // original filename
        $table->string('mime_type')->nullable();
        $table->bigInteger('size')->default(0);
        $table->string('version')->nullable()->default('1.0');
        $table->text('description')->nullable();
        $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
