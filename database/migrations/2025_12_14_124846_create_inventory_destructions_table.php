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
        Schema::create('inventory_destructions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('inventory_stock_id')->constrained('inventory_stocks')->cascadeOnDelete();
            $table->date('destruction_date');
            $table->string('reason');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_destructions');
    }
};
