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
        Schema::create('stock_movement', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->enum('movement_type', ['in', 'out', 'adjustment']); // Tambahkan 'adjustment' sebagai tipe
            $table->integer('quantity');
            $table->timestamps();

            // Definisi foreign key
            $table->foreign('kode_barang')
                ->references('kode_barang')
                ->on('barang')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movement');
    }
};
