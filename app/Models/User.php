<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false; 

    protected $fillable = [
        'id',
        'username',
        'foto',
        'password',
        'roles_id',
        'status_active',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi ke Role
    public function roles()
    {
        return $this->belongsTo(Role::class, 'roles_id');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'nrp', 'id'); // user.id → mahasiswa.nrp
    }

    // Menggunakan username untuk autentikasi
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function isAdmin()
    {
        return $this->roles && $this->roles->name === 'admin';
    }

    public function isUser()
    {
        return $this->roles && $this->roles->name === 'user';
    }

    public function isDosen()
    {
        return $this->roles && $this->roles->name === 'dosen';
    }

    // Timestamp
    public $timestamps = false;
}
