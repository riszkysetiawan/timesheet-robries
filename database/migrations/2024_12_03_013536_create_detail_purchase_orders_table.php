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
        Schema::create('detail_purchase_order', function (Blueprint $table) {
            $table->string('kode_po');
            $table->string('kode_produk');
            $table->string('qty');
            $table->string('satuan');
            $table->string('sub_total');
            $table->string('harga');
            $table->string('keterangan')->nullable();
            $table->foreign('kode_po')->references('kode_po')->on('purchase_order')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_purchase_order');
    }
};
