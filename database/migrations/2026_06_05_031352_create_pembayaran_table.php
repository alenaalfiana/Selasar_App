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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pendaftaran_id')
                ->unique()
                ->constrained('pendaftaran')
                ->cascadeOnDelete();

            $table->string('foto_bukti_pembayaran')->nullable();
            $table->enum('status', ['pending', 'valid', 'ditolak'])->default('pending');
            $table->dateTime('waktu_bayar')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
