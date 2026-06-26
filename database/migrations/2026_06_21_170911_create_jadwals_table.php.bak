<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->unsignedBigInteger('id_lapangan');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('ketersediaan', ['tersedia', 'dipesan'])->default('tersedia');
            $table->timestamps();

            $table->foreign('id_lapangan')
                  ->references('id_lapangan')
                  ->on('lapangans')
                  ->onDelete('cascade');

            // Prevent duplicate slots on same field + date + time
            $table->unique(['id_lapangan', 'tanggal', 'jam_mulai', 'jam_selesai'], 'unique_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
