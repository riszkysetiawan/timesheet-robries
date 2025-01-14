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
        Schema::create('inbound', function (Blueprint $table) {
            $table->string('kode_po')->primary();
            $table->unsignedBigInteger('id_supplier');
            $table->date('tgl_kedatangan')->nullable();
            $table->string('catatan')->nullable();
            $table->foreign('id_supplier')->references('id')->on('supplier')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbonds');
    }
};
