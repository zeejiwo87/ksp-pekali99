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
        Schema::create('aturan_pinjaman', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('penghasilan_min');
            $table->bigInteger('penghasilan_max');
            $table->bigInteger('maksimal_pinjaman');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_pinjaman');
    }
};
