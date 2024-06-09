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
        Schema::create('detail_pemakaian_bahan_bakus', function (Blueprint $table) {
            $table->integer('id_pemakaian');
            $table->foreign('id_pemakaian')->references('id_pemakaian')->on('pemakaian_bahan_bakus');
            $table->integer('id_bahan_baku');
            $table->foreign('id_bahan_baku')->references('id_bahan_baku')->on('bahan_bakus');
            $table->integer('kuantitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pemakaian_bahan_bakus');
    }
};