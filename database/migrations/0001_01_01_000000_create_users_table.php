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
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            // Identitas
            $table->string('kode_user')->unique();

            $table->string('name');

            $table->string('username')->unique();

            $table->string('email')->nullable();

            $table->string('nik', 16)->nullable();

            $table->enum('jenis_kelamin', [
                'L',
                'P'
            ]);

            $table->string('tempat_lahir')->nullable();

            $table->date('tanggal_lahir')->nullable();

            $table->text('alamat')->nullable();

            $table->string('no_hp', 20)->nullable();

            // Foto
            $table->string('foto')->nullable();

            // Login
            $table->string('password');

            // Hak akses
            $table->enum('role', [
                'admin',
                'petugas',
                'pimpinan'
            ])->default('petugas');

            // Status akun
            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            // Login terakhir
            $table->timestamp('last_login_at')->nullable();

            // Remember login
            $table->rememberToken();

            $table->timestamps();

            // Soft delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
