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
        Schema::create('waste', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk');
            $table->string('jumlah');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_alasan')->nullable();
            $table->timestamps();
            $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_alasan')->references('id')->on('alasan_waste')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste');
    }
};
