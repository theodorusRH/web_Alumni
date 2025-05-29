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
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->string('nrp', 9);
            $table->unsignedBigInteger('idjurusan');
            $table->year('angkatan')->nullable();
            $table->date('tanggallulus')->nullable();
            $table->integer('jmlsemester')->nullable();
            $table->float('ipk')->nullable();
            $table->timestamps();

            $table->primary(['nrp', 'idjurusan']);
            $table->foreign('nrp')->references('nrp')->on('mahasiswa');
            $table->foreign('idjurusan')->references('idjurusan')->on('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan');
    }
};
