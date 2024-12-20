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
        Schema::create('produk', function (Blueprint $table) {
            $table->string('kode_produk')->primary();
            $table->string('nama_barang');
            $table->string('gambar')->nullable();
            // $table->string('kode_barcode')->nullable();
            // $table->string('harga')->nullable();
            // $table->string('keterangan')->nullable();
            // $table->unsignedBigInteger('id_kategori')->nullable();
            $table->unsignedBigInteger('id_size')->nullable();
            $table->unsignedBigInteger('id_warna')->nullable();
            $table->timestamps();

            // $table->foreign('id_kategori')->references('id')->on('kategori_barang')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_warna')->references('id')->on('warna')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_size')->references('id')->on('size')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
