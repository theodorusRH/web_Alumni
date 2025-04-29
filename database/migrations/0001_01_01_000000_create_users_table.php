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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement()->primary();
            $table->string('username', 45);
            $table->string('password', 255);
            $table->integer('employees_id')->unsigned();
            $table->integer('roles_id')->unsigned();
            $table->tinyInteger('status_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
