<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus kolom employees_id
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'employees_id')) {
                $table->dropColumn('employees_id');
            }
        });

        // Ubah kolom id: Hapus auto increment via raw SQL
        DB::statement('ALTER TABLE users MODIFY id INT UNSIGNED NOT NULL');
    }

    public function down(): void
    {
        // Tambah kembali kolom employees_id jika dibutuhkan
        Schema::table('users', function (Blueprint $table) {
            $table->integer('employees_id')->unsigned()->nullable();
        });

        // Kembalikan kolom id jadi auto increment via raw SQL
        DB::statement('ALTER TABLE users MODIFY id INT UNSIGNED NOT NULL AUTO_INCREMENT');
    }
};

