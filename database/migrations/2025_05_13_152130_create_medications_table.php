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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('dosage_form');
            $table->string('strength');
            $table->string('generic_name');
            $table->string('barcode');
            $table->string('image')->nullable();
            $table->integer('price')->default(0);
            $table->integer('quantity')->default(0);
            $table->foreignId('pharmacy_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Indexes for fast searching
            $table->index('name');
            $table->index('generic_name');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
