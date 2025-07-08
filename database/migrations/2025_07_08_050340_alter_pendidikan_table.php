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
        Schema::table('pendidikan', function (Blueprint $table) {
            // Fix tipe agar cocok dengan jurusan.id
            $table->unsignedBigInteger('idjurusan')->change();

            // Tambahkan foreign key
            $table->foreign('idjurusan')
                  ->references('idjurusan')
                  ->on('jurusan')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pendidikan', function (Blueprint $table) {
            $table->dropForeign(['idjurusan']);
        });
    }
};
