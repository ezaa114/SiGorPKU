<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id('id_lapangan');
            $table->unsignedBigInteger('id_venue');
            $table->unsignedBigInteger('id_jenis');
            $table->string('nama_lapangan', 100);
            $table->decimal('harga_per_jam', 10, 2);
            $table->enum('status', ['tersedia', 'nonaktif'])->default('tersedia');
            $table->timestamps();

            $table->foreign('id_venue')
                  ->references('id_venue')
                  ->on('venues')
                  ->onDelete('cascade');

            $table->foreign('id_jenis')
                  ->references('id_jenis')
                  ->on('jenis_lapangans')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};
