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
        Schema::create('nasabah', function (Blueprint $table) {

            $table->id();

            // Identitas
            $table->string('kode_nasabah')->unique();
            $table->string('nik', 16)->unique();
            $table->string('nama');

            // Biodata
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            // Kontak
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('pendapatan')->nullable();

            // Dokumen
            $table->string('foto')->nullable();
            $table->string('foto_ktp')->nullable();

            // Data koperasi
            $table->date('tanggal_daftar');
            $table->enum('status', ['aktif', 'nonaktif'])
                ->default('aktif');

            // Petugas input
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabah');
    }
};
