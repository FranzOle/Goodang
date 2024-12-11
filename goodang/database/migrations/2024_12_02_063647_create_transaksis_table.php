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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_gudang')->constrained('gudangs');
            $table->string('deskripsi_tujuan', 255);
            $table->string('kode_referensi', 255)->unique(); // Kode unik
            $table->date('tanggal');
            $table->enum('stock_type', ['in', 'out']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
