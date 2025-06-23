<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';
    protected $primaryKey = 'nrp';
    public $incrementing = false;
    
    protected $fillable = [
        'nrp',
        'idjenispekerjaan',
        'bidangusaha',
        'perusahaan',
        'telepon',
        'mulaikerja',
        'gajipertama',
        'alamat',
        'kota',
        'kodepos',
        'idpropinsi',
        'jabatan'
    ];

    protected $dates = [
        'mulaikerja'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }

    public function jenisPekerjaan()
    {
        return $this->belongsTo(JenisPekerjaan::class, 'idjenispekerjaan', 'idjenispekerjaan');
    }

    public function propinsi()
    {
        return $this->belongsTo(Propinsi::class, 'idpropinsi', 'idpropinsi');
    }
}
