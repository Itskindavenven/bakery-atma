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
        Schema::create('produk', function(Blueprint $table){
            $table->id('id_produk');
            $table->string('nama');
            $table->string('jenis');
            $table->decimal('harga', 10, 2); // Ubah tipe data harga menjadi decimal
            $table->integer('jmlh_stok');
            $table->string('status'); // Ubah tipe data status menjadi string
            $table->foreignId('id_penitip');
            $table->text('deskripsi')->nullable(); // Tambahkan kolom deskripsi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
