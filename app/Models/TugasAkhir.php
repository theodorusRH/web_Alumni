<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $table = 'tugas_akhir';
    protected $primaryKey = 'nrp';
    public $incrementing = false;
    
    public $timestamps = false;
    protected $fillable = [
        'nrp',
        'judul',
        'kode_dosen1',
        'kode_dosen2',
        'tanggal_lulus_ta',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }

    public function tugasAkhir()
    {
        return $this->belongsTo(User::class, 'id', 'nrp');
    }

    public function dosen1()
    {
        return $this->belongsTo(Dosen::class, 'kode_dosen1', 'kode');
    }

    public function dosen2()
    {
        return $this->belongsTo(Dosen::class, 'kode_dosen2', 'kode');
    }

}
