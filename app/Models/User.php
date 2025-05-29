<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'roles_id',
        'employees_id',
        'status_active',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relasi ke Role
    public function roles()
    {
        return $this->belongsTo(Role::class, 'roles_id');
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


    // Timestamp
    public $timestamps = false;
}
