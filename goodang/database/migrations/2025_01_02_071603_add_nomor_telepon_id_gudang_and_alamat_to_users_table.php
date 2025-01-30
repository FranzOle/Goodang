<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable()->after('email');
            $table->unsignedBigInteger('no_goodang')->nullable()->after('nomor_telepon');
            $table->string('alamat')->nullable()->after('no_goodang');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nomor_telepon', 'no_goodang', 'alamat']);
        });
    }
};
