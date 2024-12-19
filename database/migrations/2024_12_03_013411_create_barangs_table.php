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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kode_barang')->primary();
            $table->string('nama_barang');
            $table->unsignedBigInteger('id_satuan');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->timestamps();
            $table->foreign('id_satuan')->references('id')->on('satuan_barang')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_kategori')->references('id')->on('kategori_barang')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
