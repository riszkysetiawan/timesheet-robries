<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('production', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('so_number');
    //         $table->date('tgl_production');
    //         $table->timestamps();
    //     });
    // }
    public function up(): void
    {
        Schema::create('production', function (Blueprint $table) {
            $table->id();
            $table->string('so_number');
            $table->string('nama_produk');
            $table->date('tgl_production');
            $table->unsignedBigInteger('id_size');
            $table->unsignedBigInteger('id_color');
            $table->string('qty');
            $table->string('barcode')->unique();
            $table->string('finish_rework')->nullable();
            $table->string('progress')->nullable();
            $table->string('catatan')->nullable();
            // $table->string('kode_produk');
            // $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_color')->references('id')->on('warna')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_size')->references('id')->on('size')->onDelete('restrict')->onUpdate('cascade');

            // $table->foreign('id_proses')->references('id')->on('proses')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production');
    }
};
