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
        Schema::create('timer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proses');
            $table->unsignedBigInteger('id_production');
            // $table->string('so_number');
            // $table->string('barcode');
            $table->time('waktu')->nullable();
            $table->unsignedBigInteger('id_users');
            $table->foreign('id_proses')->references('id')->on('proses')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_production')->references('id')->on('production')->onDelete('restrict')->onUpdate('cascade');
            // $table->foreign('barcode')->references('barcode')->on('production')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timer');
    }
};
