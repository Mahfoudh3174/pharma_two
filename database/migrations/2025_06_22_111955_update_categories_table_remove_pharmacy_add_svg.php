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
        Schema::table('categories', function (Blueprint $table) {
            // Remove pharmacy_id foreign key and column
            $table->dropForeign(['pharmacy_id']);
            $table->dropColumn('pharmacy_id');
            
            // Add new columns
            $table->string('svg_logo')->nullable()->after('name');
            $table->boolean('is_active')->default(true)->after('svg_logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['svg_logo', 'is_active']);
            
            // Add back pharmacy_id
            $table->foreignId('pharmacy_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }
};
