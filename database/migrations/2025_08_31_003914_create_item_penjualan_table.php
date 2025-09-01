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
        Schema::create('item_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('penjualans')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs');
            $table->unsignedInteger('qty');
            $table->unsignedBigInteger('harga_satuan');
            $table->unsignedBigInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_penjualan');
    }
};
