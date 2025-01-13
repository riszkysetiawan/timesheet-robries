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
        Schema::create('daily_stock_histories', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->date('rekap_date'); // Penyesuaian nama sesuai kode
            $table->integer('total_in')->default(0); // Total barang masuk
            $table->integer('total_out')->default(0); // Total barang keluar
            $table->integer('ending_stock')->default(0); // Stok akhir
            $table->timestamps();

            // Relasi ke tabel barang
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_stock_histories');
    }
};
