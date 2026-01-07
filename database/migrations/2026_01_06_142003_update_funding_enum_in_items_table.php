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
        Schema::table('items', function (Blueprint $table) {
            $table->enum('funding', ['BPOPP 1', 'BPOPP 2', 'BPOPP 3', 'BPOPP 4', 'BPOPP 5', 'BOSP 1', 'BOSP 2', 'BOSP 3', 'BOSP 4', 'BOSP 5', 'Komite', 'Bantuan pusat', 'Lain-lain'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->enum('funding', ['BPOPV', 'BOSP', 'Komite', 'Bantuan pusat', 'Lain-lain'])->change();
        });
    }
};
