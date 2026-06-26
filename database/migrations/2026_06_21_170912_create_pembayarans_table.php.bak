<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pemesanan');
            $table->date('tgl_bayar');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->string('bukti_transfer')->nullable(); // path to uploaded file
            $table->enum('metode_bayar', ['transfer_bank', 'tunai'])->default('transfer_bank');
            $table->enum('status_bayar', ['menunggu', 'dikonfirmasi', 'ditolak'])->default('menunggu');
            $table->timestamps();

            $table->foreign('id_pemesanan')
                  ->references('id_pemesanan')
                  ->on('pemesanans')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
