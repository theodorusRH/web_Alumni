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

        DB::statement('ALTER TABLE pekerjaan DROP PRIMARY KEY');

        Schema::table('pekerjaan', function (Blueprint $table) {
            // Tambah primary key gabungan
            $table->primary(['nrp', 'idjenispekerjaan', 'idpropinsi']);

            // Tambahkan foreign key lagi
            $table->foreign('nrp')->references('nrp')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pekerjaan', function (Blueprint $table) {
            $table->dropForeign(['nrp']);
            $table->dropPrimary();
        });

        DB::statement('ALTER TABLE pekerjaan ADD PRIMARY KEY (nrp)');

        Schema::table('pekerjaan', function (Blueprint $table) {
            $table->foreign('nrp')->references('nrp')->on('mahasiswa')->onDelete('cascade');
        });
    }
};
