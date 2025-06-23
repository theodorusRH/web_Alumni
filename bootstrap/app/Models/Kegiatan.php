<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari nama model secara default
    // protected $table = 'kegiatans';

    // Mass assignment: field yang bisa diisi secara massal
    protected $fillable = [
        'judul',
        'tanggal',
        'deskripsi',
        'foto',
    ];

    // Jika kamu ingin memformat tanggal sebagai instance Carbon (opsional)
    protected $dates = ['tanggal'];
}
