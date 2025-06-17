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
        Schema::create('kontak', function (Blueprint $table) {
            $table->id('idkontak');
            $table->string('email', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->text('gps')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('website', 45)->nullable();
            $table->string('instagram', 45)->nullable();
            $table->string('twitter', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak');
    }
};
