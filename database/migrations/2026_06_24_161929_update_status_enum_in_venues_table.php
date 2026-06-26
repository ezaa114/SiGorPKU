<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'pgsql') {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE venues DROP CONSTRAINT IF EXISTS venues_status_check");
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE venues ADD CONSTRAINT venues_status_check CHECK (status IN ('aktif', 'nonaktif', 'renovasi', 'tutup'))");
        } else {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE venues MODIFY COLUMN status ENUM('aktif', 'nonaktif', 'renovasi', 'tutup') DEFAULT 'aktif'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'pgsql') {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE venues DROP CONSTRAINT IF EXISTS venues_status_check");
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE venues ADD CONSTRAINT venues_status_check CHECK (status IN ('aktif', 'nonaktif'))");
        } else {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE venues MODIFY COLUMN status ENUM('aktif', 'nonaktif') DEFAULT 'aktif'");
        }
    }
};
