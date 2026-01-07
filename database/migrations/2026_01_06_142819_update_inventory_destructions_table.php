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
        Schema::table('inventory_destructions', function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->string('news')->nullable()->after('reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_destructions', function (Blueprint $table) {
            $table->text('notes')->nullable();
            $table->dropColumn('news');
        });
    }
};
