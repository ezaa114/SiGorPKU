<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venue_closures', function (Blueprint $table) {
            $table->id('id_closure');
            $table->unsignedBigInteger('id_venue');
            $table->date('tanggal');
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_venue')
                  ->references('id_venue')
                  ->on('venues')
                  ->onDelete('cascade');

            // Unique closure date per venue
            $table->unique(['id_venue', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venue_closures');
    }
};
