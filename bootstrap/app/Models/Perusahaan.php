<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';
    protected $primaryKey = 'idperusahaan';
    
    protected $fillable = [
        'nama',
        'alamat',
        'kota',
        'telepon',
        'website',
        'email',
        'isactive',
        'idpropinsi',
        'userid'
    ];

    public function propinsi()
    {
        return $this->belongsTo(Propinsi::class, 'idpropinsi', 'idpropinsi');
    }

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'idperusahaan', 'idperusahaan');
    }
}
