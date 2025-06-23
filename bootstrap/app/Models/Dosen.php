<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'kode',
        'nama',
    ];

    // Relasi ke tugas akhir sebagai dosen pembimbing 1
    public function tugasAkhirSebagaiPembimbing1()
    {
        return $this->hasMany(TugasAkhir::class, 'kode_dosen1', 'kode');
    }

    // Relasi ke tugas akhir sebagai dosen pembimbing 2
    public function tugasAkhirSebagaiPembimbing2()
    {
        return $this->hasMany(TugasAkhir::class, 'kode_dosen2', 'kode');
    }
}
