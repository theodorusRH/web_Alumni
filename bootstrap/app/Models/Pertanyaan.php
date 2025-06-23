<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';
    protected $primaryKey = 'idpertanyaan';

    protected $fillable = [
        'nama', 
        'email', 
        'pesan', 
        'isread'
    ];

    // Timestamp
    // public $timestamps = false;
}
