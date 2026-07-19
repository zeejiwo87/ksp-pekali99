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
        Schema::create('pinjaman', function (Blueprint $table) {

            $table->id();

            // 🔗 RELASI
            $table->foreignId('nasabah_id')
                ->constrained('nasabah')
                ->cascadeOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // 📌 IDENTITAS PINJAMAN
            $table->string('kode_pinjaman')->unique();

            // 💰 POKOK PINJAMAN
            $table->integer('jumlah_pinjaman');

            // ⏳ TENOR FLEXIBLE
            $table->integer('tenor');
            $table->enum('tenor_satuan', ['minggu', 'bulan', 'tahun'])
                ->default('minggu');

            // 📈 BUNGA (FLEXIBLE INPUT)
            $table->decimal('bunga_persen', 5, 2);

            // 🧮 HASIL PERHITUNGAN
            $table->integer('total_pinjaman')->nullable();
            $table->integer('angsuran_per_periode')->nullable();

            // 📅 TANGGAL
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo')->nullable();

            // 📌 STATUS PINJAMAN
            $table->enum('status', ['aktif', 'lunas', 'macet'])
                ->default('aktif');

            $table->timestamps();

            // 🗑 soft delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
