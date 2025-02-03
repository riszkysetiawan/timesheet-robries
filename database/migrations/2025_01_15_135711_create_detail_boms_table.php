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
        Schema::create('detail_bom', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id_bom');
            $table->string('kode_barang')->nullable();
            $table->string('persentase')->nullable();
            $table->string('gramasi')->nullable();
            $table->timestamps();
            $table->foreign('id_bom')->references('id')->on('bom')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_bom');
    }
};
