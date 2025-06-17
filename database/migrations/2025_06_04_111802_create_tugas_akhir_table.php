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
        Schema::create('tugas_akhir', function (Blueprint $table) {
            $table->string('nrp', 9)->primary(); // NOT NULL
            $table->text('judul'); // NOT NULL
            $table->string('kode_dosen1', 8)->nullable(); // DEFAULT NULL
            $table->string('kode_dosen2', 8)->nullable(); // DEFAULT NULL
            $table->integer('lulus_ta')->nullable(); // DEFAULT NULL
            $table->integer('selesai_kuliah')->nullable(); // DEFAULT NULL
            $table->string('nilai_ta', 3)->nullable(); // DEFAULT NULL
            $table->date('tanggal_lulus_ta')->nullable(); // DEFAULT NULL
            $table->boolean('editable')->default(1); // NOT NULL DEFAULT 1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_akhir');
    }
};
