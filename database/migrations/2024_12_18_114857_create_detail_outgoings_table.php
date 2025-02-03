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
        Schema::create('detail_outgoing', function (Blueprint $table) {
            $table->unsignedBigInteger('id_outgoing');
            $table->string('kode_produk')->nullable();
            $table->string('kode_barang')->nullable();
            $table->string('qty')->nullable();
            $table->foreign('id_outgoing')->references('id')->on('outgoing')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_outgoing');
    }
};
