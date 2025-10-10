<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rat extends Model
{
    use HasFactory;

    protected $table = 'rats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'idAdoptiondelivery',
        'idUser', 
        'name',
        'color',
        'sex',
        'ageMonths',
        'type',
        'adoptedAt',
        'status',
        'idSpecialrat'
    ];

    protected $casts = [
        'adoptedAt' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function specialrat()
    {
        return $this->belongsTo(Specialrat::class, 'idSpecialrat');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function adoptiondelivery()
    {
        return $this->belongsTo(Adoptiondelivery::class, 'idAdoptiondelivery');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 1)
                    ->whereNull('idUser')
                    ->whereNull('adoptedAt');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}