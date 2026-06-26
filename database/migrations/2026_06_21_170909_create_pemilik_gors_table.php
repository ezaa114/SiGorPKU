<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemilik_gors', function (Blueprint $table) {
            $table->id('id_pemilik');
            $table->string('nama', 100);
            $table->string('no_telepon', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('nama_usaha', 150);
            $table->enum('status_verifikasi', ['pending', 'terverifikasi', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemilik_gors');
    }
};
