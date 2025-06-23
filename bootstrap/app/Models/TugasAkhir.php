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
    
    protected $fillable = [
        'judul',
        'kode_dosen1',
        'kode_dosen2',
        'lulus_ta',
        'selesai_kuliah',
        'nilai_ta',
        'tanggal_lulus_ta',
        'editable'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
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
