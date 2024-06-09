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
        Schema::create('transaksi', function (Blueprint $table){
            $table->string('nomor_transaksi')->primary();
            $table->bigInteger('id_customer');
            $table->date('tanggal_pemesanan')->nullable();
            $table->date('tanggal_pengambilan');
            $table->string('pengambilan');
            $table->float('jarak')->default(0);
            $table->integer('total_harga')->default(0);
            $table->date('tanggal_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->integer('poin')->default(0);
            $table->string('status')->default('Waiting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
