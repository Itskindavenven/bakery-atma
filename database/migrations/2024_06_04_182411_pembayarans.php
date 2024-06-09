<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up() : void
    // {
    //     Schema::create('pembayarans', function (Blueprint $table) {
    //         $table->string('nomor_transaksi');
    //         $table->foreign('nomor_transaksi')->references('nomor_transaksi')->on('transaksis');
    //         $table->integer('total_harga')->default(0);
    //         $table->integer('uang_diterima')->default(0);
    //         $table->integer('tip')->default(0);
    //         $table->date('tanggal_pembayaran')->nullable();
    //         $table->string('bukti_pembayaran')->nullable();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down() : void
    // {
    //     Schema::dropIfExists('pembayarans');
    // }
};
