<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'idjurusan';
    
    protected $fillable = [
        'nama'
    ];

    public function pendidikan()
    {
        return $this->hasMany(Pendidikan::class, 'idjurusan', 'idjurusan');
    }
}
