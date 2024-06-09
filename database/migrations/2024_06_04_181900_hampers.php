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
        Schema::create('hampers', function(Blueprint $table){
            $table->id('id_hampers');
            $table->string('nama');
            $table->decimal('harga', 10, 2);
            $table->string('status');
            $table->text('deskripsi')->nullable(); // Tambahkan kolom deskripsi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hampers');
    }
};
