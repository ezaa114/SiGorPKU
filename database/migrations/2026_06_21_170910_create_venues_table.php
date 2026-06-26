<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id('id_venue');
            $table->unsignedBigInteger('id_pemilik');
            $table->string('nama_venue', 150);
            $table->text('alamat');
            $table->string('kecamatan', 100);
            $table->string('no_telepon', 20)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('id_pemilik')
                  ->references('id_pemilik')
                  ->on('pemilik_gors')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
