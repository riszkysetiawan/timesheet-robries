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
        Schema::create('detail_inbound', function (Blueprint $table) {
            $table->string('kode_po');
            $table->string('kode_barang');
            $table->string('qty_po');
            $table->string('qty_actual');
            $table->string('reject')->nullable();
            $table->string('final_qty');
            $table->string('satuan')->nullable();
            $table->string('gambar')->nullable();
            $table->string('keterangan')->nullable();
            $table->foreign('kode_po')->references('kode_po')->on('inbound')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_inbonds');
    }
};
