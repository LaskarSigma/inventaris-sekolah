<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->date('entry_date');
            $table->string('name_address');
            $table->date('receipt_date');
            $table->string('receipt_no', 10);
            $table->text('description');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total_price');
            $table->enum('funding', ['BPOPV', 'BOSP', 'Komite', 'Bantuan pusat', 'Lain-lain']);
            $table->foreignUlid('inventory_code_id')->nullable()->constrained()->nullOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
