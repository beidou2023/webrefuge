<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'integer',
        'status' => 'integer',
    ];

    public function adoptionrequests()
    {
        return $this->hasMany(Adoptionrequest::class, 'idUser');
    }

    public function rats()
    {
        return $this->hasMany(Rat::class, 'idUser');
    }

    public function refuges()
    {
        return $this->hasMany(Refuge::class, 'idManager');
    }

    public function isAdmin()
    {
        return $this->role === 3;
    }

    public function isManager()
    {
        return $this->role === 2;
    }

    public function isUser()
    {
        return $this->role === 1;
    }

    public function getFullNameAttribute()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}