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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nrp', 9)->primary();
            $table->string('nama', 40)->nullable();
            $table->string('alamat', 50)->nullable();
            $table->string('kota', 20)->nullable();
            $table->string('kodepos', 5)->nullable();
            $table->enum('sex', ['Pria', 'Wanita'])->nullable();
            $table->string('email', 50)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('hp', 20)->nullable();
            $table->string('tmptlahir', 20)->nullable();
            $table->date('tgllahir')->nullable();
            $table->string('alamatluarkota', 50)->nullable();
            $table->string('kotaluarkota', 20)->nullable();
            $table->string('kodeposluarkota', 5)->nullable();
            $table->string('teleponluarkota', 20)->nullable();
            $table->unsignedBigInteger('idpropinsi');
            $table->tinyInteger('iscomplete')->default(0);
            $table->timestamps();

            $table->foreign('idpropinsi')->references('idpropinsi')->on('propinsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
