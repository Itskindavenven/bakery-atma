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
        Schema::create('pegawai', function(Blueprint $table){
         $table->id('id_pegawai');
         $table->string('nama_lengkap');
         $table->date('tanggal_lahir');
         $table->foreignId('id_role');
         $table->string('email')->unique();
         $table->string('username')->unique();
         $table->string('password');
         $table->string('verify_key');
         $table->integer('active')->nullable();
         $table->timestamps();
         $table->timestamp('email_verified_at')->nullable();
         $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
