<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';
    protected $primaryKey = 'idlowongan';
    
    protected $fillable = [
        'jabatan',
        'deskripsi',
        'kualifikasi',
        'gajimin',
        'gajimax',
        'tanggal',
        'tanggal_max',
        'isactive',
        'kirim',
        'idperusahaan',
        'userid'
    ];

    protected $dates = [
        'tanggal',
        'tanggal_max'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'idperusahaan', 'idperusahaan');
    }
}
