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
        Schema::create('angsuran', function (Blueprint $table) {

            $table->id();

            // Relasi ke pinjaman
            $table->foreignId('pinjaman_id')
                ->constrained('pinjaman')
                ->cascadeOnDelete();

            // Urutan angsuran
            $table->integer('angsuran_ke');

            // Jadwal
            $table->date('tanggal_jatuh_tempo');

            // Nominal tagihan
            $table->decimal('jumlah_tagihan', 15, 2);

            // Pembayaran
            $table->date('tanggal_bayar')->nullable();

            $table->decimal('jumlah_bayar', 15, 2)
                ->nullable();

            // Petugas yang menerima pembayaran
            $table->foreignId('dibayar_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Bukti pembayaran
            $table->string('foto_bukti')
                ->nullable();

            // Catatan
            $table->text('keterangan')
                ->nullable();

            // Status
            $table->enum('status', [
                'belum_bayar',
                'lunas',
                'telat'
            ])->default('belum_bayar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsuran');
    }
};
