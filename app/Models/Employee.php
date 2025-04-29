<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    
    protected $table = 'employees';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
        'gender',
        'status_active',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'employees_id');
    }
}
