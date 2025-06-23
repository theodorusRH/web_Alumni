<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propinsi extends Model
{
    use HasFactory;

    protected $table = 'propinsi';
    protected $primaryKey = 'idpropinsi';
    
    protected $fillable = [
        'nama',
        'isactive'
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'idpropinsi', 'idpropinsi');
    }

    public function perusahaan()
    {
        return $this->hasMany(Perusahaan::class, 'idpropinsi', 'idpropinsi');
    }
}

