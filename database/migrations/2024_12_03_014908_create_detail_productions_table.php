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
        Schema::create('detail_production', function (Blueprint $table) {
            // $table->id();
            $table->string('so_number');
            $table->string('size');
            $table->string('color');
            $table->string('qty');
            $table->string('kode_produk')->nullable();
            $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('so_number')->references('so_number')->on('production')->onDelete('restrict')->onUpdate('restrict');

            // $table->foreign('id_proses')->references('id')->on('proses')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_production');
    }
};
