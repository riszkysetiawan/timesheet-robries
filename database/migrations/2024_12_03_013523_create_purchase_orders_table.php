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
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->string('kode_po')->unique();
            $table->unsignedBigInteger('id_supplier');
            $table->date('tgl_buat');
            $table->date('eta')->nullable();
            $table->string('total');
            $table->string('status');
            $table->foreign('id_supplier')->references('id')->on('supplier')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order');
    }
};
