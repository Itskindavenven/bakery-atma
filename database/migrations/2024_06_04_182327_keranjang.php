<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('keranjang', function (Blueprint $table) {
    //         $table->string('nomor_transaksi');
    //         $table->foreign('nomor_transaksi')->references('nomor_transaksi')->on('transaksi');
    //         $table->integer('id_produk')->nullable();
    //         $table->foreign('id_produk')->references('id_produk')->on('produks');
    //         $table->integer('id_hampers')->nullable();
    //         $table->foreign('id_hampers')->references('id_hampers')->on('hampers');
    //         $table->integer('jumlah_produk');
    //         $table->integer('subtotal');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('keranjang');
    // }
};
