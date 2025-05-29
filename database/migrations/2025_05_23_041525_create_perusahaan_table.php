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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id('idperusahaan');
            $table->string('nama', 45)->nullable();
            $table->string('alamat', 50)->nullable();
            $table->string('kota', 20)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('website', 45)->nullable();
            $table->string('email', 50)->nullable();
            $table->tinyInteger('isactive')->default(1);
            $table->unsignedBigInteger('idpropinsi');
            $table->string('userid', 20);
            $table->timestamps();

            $table->foreign('idpropinsi')->references('idpropinsi')->on('propinsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
