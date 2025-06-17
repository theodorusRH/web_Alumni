<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nrp';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'nrp',
        'nama',
        'alamat',
        'kota',
        'kodepos',
        'sex',
        'email',
        'telepon',
        'hp',
        'tmptlahir',
        'tgllahir',
        'alamatluarkota',
        'kotaluarkota',
        'kodeposluarkota',
        'teleponluarkota',
        'idpropinsi',
        'iscomplete'
    ];

    protected $casts = [
        'tgllahir' => 'date',
    ];

    protected $dates = [
        'tgllahir'
    ];

    public function propinsi()
    {
        return $this->belongsTo(Propinsi::class, 'idpropinsi', 'idpropinsi');
    }

    public function pendidikan()
    {
        return $this->hasMany(Pendidikan::class, 'nrp', 'nrp');
    }

    public function pekerjaan()
    {
        return $this->hasMany(Pekerjaan::class, 'nrp', 'nrp');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nrp', 'id');
    }

    public function tugasAkhir()
    {
        return $this->hasOne(TugasAkhir::class, 'nrp', 'nrp');
    }

    // Check if student is alumni (has graduation data)
    public function isAlumni()
    {
        return $this->pendidikan()->whereNotNull('tanggallulus')->exists();
    }
}
