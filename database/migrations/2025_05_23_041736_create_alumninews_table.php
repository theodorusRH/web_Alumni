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
        Schema::create('alumninews', function (Blueprint $table) {
            $table->id('idalumninews');
            $table->string('judul', 45)->nullable();
            $table->text('isi')->nullable();
            $table->date('tanggalbuat')->nullable();
            $table->tinyInteger('isactive')->default(1);
            $table->string('userid', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumninews');
    }
};
