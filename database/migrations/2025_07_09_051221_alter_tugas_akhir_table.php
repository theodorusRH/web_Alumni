<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up()
    {
        Schema::table('tugas_akhir', function (Blueprint $table) {
            // Drop kolom jika ada
            if (Schema::hasColumn('tugas_akhir', 'nilai_ta')) {
                $table->dropColumn('nilai_ta');
            }

            if (Schema::hasColumn('tugas_akhir', 'lulus_ta')) {
                $table->dropColumn('lulus_ta');
            }

            if (Schema::hasColumn('tugas_akhir', 'selesai_kuliah')) {
                $table->dropColumn('selesai_kuliah');
            }

            if (Schema::hasColumn('tugas_akhir', 'editable')) {
                $table->dropColumn('editable');
            }

            // Foreign key relasi dosen
            $table->foreign('kode_dosen1')
                ->references('kode')->on('dosen')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('kode_dosen2')
                ->references('kode')->on('dosen')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down()
    {
        Schema::table('tugas_akhir', function (Blueprint $table) {
            // Tambahkan kembali kolom
            $table->string('nilai_ta', 3)->nullable();
            $table->integer('lulus_ta')->nullable();
            $table->integer('selesai_kuliah')->nullable();
            $table->tinyInteger('editable')->default(1);

            // Drop foreign key
            $table->dropForeign(['kode_dosen1']);
            $table->dropForeign(['kode_dosen2']);
        });
    }
};
