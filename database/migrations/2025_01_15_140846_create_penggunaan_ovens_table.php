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
        Schema::create('penggunaan_oven', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_oven');
            $table->string('kode_barang');
            $table->string('qty');
            $table->date('tgl');
            $table->timestamps();
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_oven')->references('id')->on('oven')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('penggunaan_oven');
    }
};
