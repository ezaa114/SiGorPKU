<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_jadwal');
            $table->date('tgl_pesan');
            $table->decimal('total_harga', 10, 2);
            $table->enum('status_pesan', [
                'menunggu_pembayaran',
                'menunggu_konfirmasi',
                'dikonfirmasi',
                'dibatalkan'
            ])->default('menunggu_pembayaran');
            $table->timestamps();

            $table->foreign('id_pelanggan')
                  ->references('id_pelanggan')
                  ->on('pelanggan')
                  ->onDelete('cascade');

            $table->foreign('id_jadwal')
                  ->references('id_jadwal')
                  ->on('jadwals')
                  ->onDelete('cascade');

            // One-to-one: one jadwal can only have one pemesanan (double booking prevention)
            $table->unique('id_jadwal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
