<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('employees');
    }

    public function down(): void
    {
        Schema::create('employees', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('address');
            $table->string('gender');
            $table->tinyInteger('status_active');
        });
    }
};