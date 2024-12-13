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
    //     Schema::create('detail_production', function (Blueprint $table) {
    //         $table->unsignedBigInteger('id_production');
    //         $table->string('so_number');
    //         $table->string('size');
    //         $table->string('color');
    //         $table->string('qty');
    //         $table->string('barcode')->unique();
    //         // $table->datetime('oven_start')->nullable();
    //         // $table->datetime('oven_finish')->nullable();
    //         // $table->datetime('press_start')->nullable();
    //         // $table->datetime('press_finish')->nullable();
    //         // $table->datetime('wbs_start')->nullable();
    //         // $table->datetime('wbs_finish')->nullable();
    //         // $table->datetime('weld_start')->nullable();
    //         // $table->datetime('weld_finish')->nullable();
    //         // $table->datetime('vbs_start')->nullable();
    //         // $table->datetime('vbs_finish')->nullable();
    //         // $table->datetime('hbs_start')->nullable();
    //         // $table->datetime('hbs_finish')->nullable();
    //         // $table->datetime('poles_start')->nullable();
    //         // $table->datetime('poles_finish')->nullable();
    //         // $table->datetime('assembly_start')->nullable();
    //         // $table->datetime('assembly_finish')->nullable();
    //         // $table->datetime('finishing_start')->nullable();
    //         // $table->datetime('finishing_finish')->nullable();
    //         $table->string('finish_rework')->nullable();
    //         $table->string('progress')->nullable();
    //         $table->string('kode_produk')->nullable();
    //         $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('restrict')->onUpdate('cascade');
    //         $table->foreign('id_production')->references('id')->on('production')->onDelete('restrict')->onUpdate('cascade');

    //         // $table->foreign('id_proses')->references('id')->on('proses')->onDelete('restrict')->onUpdate('cascade');
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_production');
    }
};
