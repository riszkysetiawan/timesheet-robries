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
            $table->string('so_number');
            $table->unsignedBigInteger('id_users');
            $table->foreign('id_proses')->references('id')->on('proses')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('so_number')->references('so_number')->on('production')->onDelete('restrict')->onUpdate('cascade');
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
