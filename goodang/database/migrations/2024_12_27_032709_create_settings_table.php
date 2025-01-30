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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('sidebar_theme')->default('primary');
            $table->string('overall_theme')->default('primary'); 
            $table->string('font')->default('default'); 
            $table->text('terms_and_conditions')->nullable(); 
            $table->string('terms_file')->nullable(); 
            $table->string('admin_phone')->nullable();
            $table->string('company_logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
