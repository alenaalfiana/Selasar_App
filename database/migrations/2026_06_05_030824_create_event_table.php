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
        Schema::create('event', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete();
            $table->foreignId('jenis_id')->constrained('jenis')->cascadeOnDelete();

            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->string('lokasi', 150);

            $table->unsignedInteger('kapasitas');
            $table->decimal('harga', 10, 2)->default(0);

            $table->dateTime('tanggal_pelaksanaan');

            $table->string('foto_banner_event')->nullable();

            $table->string('nama_rekening', 150)->nullable();
            $table->string('no_rekening_pembayaran', 50)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
