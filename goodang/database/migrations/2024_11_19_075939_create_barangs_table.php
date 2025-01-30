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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('id_supplier')->constrained('suppliers')->onDelete('cascade');
            $table->string('kode_sku', 255);
            $table->string('nama', 255);
            $table->string('deskripsi', 1004);
            $table->decimal('harga', 15, 2)->default(0);
            $table->string('gambar');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
