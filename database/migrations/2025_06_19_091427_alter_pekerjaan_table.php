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
        Schema::table('pekerjaan', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['nrp']);
        });

        // Hapus primary key composite lama
        DB::statement('ALTER TABLE pekerjaan DROP PRIMARY KEY');

        Schema::table('pekerjaan', function (Blueprint $table) {
            // Tambah kolom id sebagai primary key baru
            $table->increments('id')->first();

            // Tambahkan kembali foreign key ke tabel mahasiswa
            $table->foreign('nrp')->references('nrp')->on('mahasiswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pekerjaan', function (Blueprint $table) {
            // Hapus foreign key dan kolom id
            $table->dropForeign(['nrp']);
            $table->dropColumn('id');
        });

        // Kembalikan primary key composite lama
        DB::statement('ALTER TABLE pekerjaan ADD PRIMARY KEY (nrp, idjenispekerjaan, idpropinsi)');

        Schema::table('pekerjaan', function (Blueprint $table) {
            $table->foreign('nrp')->references('nrp')->on('mahasiswa')->onDelete('cascade');
        });
    }
};
