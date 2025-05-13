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
        Schema::create('medication_pharmacy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medication_id')->constrained()->cascadeOnDelete();
            
            // Price and stock information
            $table->decimal('price', 8, 2); // Selling price
            $table->integer('stock')->default(0);
            $table->date('last_restocked')->nullable();
            
            $table->timestamps();
            
            // Composite index for price comparison queries
            $table->index(['medication_id', 'price', 'stock']);
            
            // Ensure each pharmacy only has one entry per medication
            $table->unique(['pharmacy_id', 'medication_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_pharmacy');
    }
};
