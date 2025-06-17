<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus primary key sementara
        DB::statement('ALTER TABLE users DROP PRIMARY KEY');

        // Ubah tipe kolom id dari INT ke VARCHAR
        DB::statement('ALTER TABLE users MODIFY id VARCHAR(50) NOT NULL');

        // Tetapkan kembali kolom id sebagai primary key
        DB::statement('ALTER TABLE users ADD PRIMARY KEY (id)');
    }

    public function down(): void
    {
        // Balik ke integer dan auto increment
        DB::statement('ALTER TABLE users DROP PRIMARY KEY');
        DB::statement('ALTER TABLE users MODIFY id INT UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE users ADD PRIMARY KEY (id)');
    }
};
