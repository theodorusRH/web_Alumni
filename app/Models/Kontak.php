<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    protected $primaryKey = 'idkontak';

    protected $fillable = [
        'alamat', 
        'email', 
        'lokasi', 
        'gps', 
        'telepon', 
        'website', 
        'instagram', 
        'twitter', 
        'isactive'
    ];
}
