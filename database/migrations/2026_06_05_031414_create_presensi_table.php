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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tiket_id')
                ->unique()
                ->constrained('tiket')
                ->cascadeOnDelete();

            $table->string('qr_scan_code', 100);
            $table->enum('status', ['hadir', 'belum hadir'])->default('belum hadir');
            $table->dateTime('waktu_scan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
