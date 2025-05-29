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
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id('idlowongan');
            $table->string('jabatan', 45)->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('kualifikasi')->nullable();
            $table->double('gajimin')->nullable();
            $table->double('gajimax')->nullable();
            $table->timestamp('tanggal')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('tanggal_max')->nullable();
            $table->tinyInteger('isactive')->default(1);
            $table->string('kirim', 75)->nullable();
            $table->unsignedBigInteger('idperusahaan');
            $table->string('userid', 20);
            $table->timestamps();

            $table->foreign('idperusahaan')->references('idperusahaan')->on('perusahaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
