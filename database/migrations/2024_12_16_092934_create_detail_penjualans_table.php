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
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->unsignedBigInteger('id_penjualan');
            $table->string('pesanan')->nullable();
            $table->string('qty')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();
            $table->foreign('id_penjualan')->references('id')->on('penjualan')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
