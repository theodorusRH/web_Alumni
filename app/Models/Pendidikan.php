<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikan';
    
    protected $fillable = [
        'nrp',
        'idjurusan',
        'angkatan',
        'tanggallulus',
        'jmlsemester',
        'ipk'
    ];

    protected $dates = [
        'tanggallulus'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'idjurusan', 'idjurusan');
    }
}
