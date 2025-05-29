<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniNews extends Model
{
    use HasFactory;

    protected $table = 'alumninews';
    protected $primaryKey = 'idalumninews';
    
    protected $fillable = [
        'judul',
        'isi',
        'tanggalbuat',
        'isactive',
        'userid',
        'foto'
    ];

    protected $dates = [
        'tanggalbuat'
    ];
}
