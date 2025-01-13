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
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // User ID
            $table->string('action'); // Aksi yang dilakukan
            $table->string('model')->nullable(); // Nama model yang terlibat
            $table->string('model_id')->nullable(); // ID dari model
            $table->text('details')->nullable(); // Detail tambahan (opsional)
            $table->string('ip_address')->nullable(); // Alamat IP user
            $table->timestamps(); // Waktu aktivitas

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
    }
};
