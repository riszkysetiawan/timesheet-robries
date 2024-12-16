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
        Schema::create('mapping', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->unsignedBigInteger('id_area');
            $table->string('stock')->nullable();
            $table->timestamps();
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_area')->references('id')->on('area_mapping')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping');
    }
};
