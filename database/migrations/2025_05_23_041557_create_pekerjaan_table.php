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
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->string('nrp', 9);
            $table->unsignedBigInteger('idjenispekerjaan');
            $table->string('bidangusaha', 30)->nullable();
            $table->string('perusahaan', 45)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->date('mulaikerja')->nullable();
            $table->integer('gajipertama')->nullable();
            $table->string('alamat', 50)->nullable();
            $table->string('kota', 20)->nullable();
            $table->string('kodepos', 5)->nullable();
            $table->unsignedBigInteger('idpropinsi');
            $table->string('jabatan', 30)->nullable();
            $table->timestamps();

            $table->primary(['nrp', 'idjenispekerjaan']);
            $table->foreign('nrp')->references('nrp')->on('mahasiswa');
            $table->foreign('idjenispekerjaan')->references('idjenispekerjaan')->on('jenispekerjaan');
            $table->foreign('idpropinsi')->references('idpropinsi')->on('propinsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjaan');
    }
};
