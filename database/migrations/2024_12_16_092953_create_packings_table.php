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
        Schema::create('packing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_vendor_pengiriman');
            $table->string('operator');
            $table->date('tgl_pengiriman');
            $table->string('foto_pengiriman');
            $table->timestamps();
            $table->foreign('id_penjualan')->references('id')->on('penjualan')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_vendor_pengiriman')->references('id')->on('vendor_pengiriman')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing');
    }
};
