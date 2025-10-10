<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rat extends Model
{
    protected $table = 'rats';

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
        'idSpecialrat',
    ];

    protected $casts = [
        'idAdoptiondelivery' => 'integer',
        'idUser' => 'integer',
        'ageMonths' => 'integer',
        'type' => 'integer',
        'status' => 'integer',
        'idSpecialrat' => 'integer',
        'adoptedAt' => 'datetime',
    ];

    public function adoptionDelivery()
    {
        return $this->belongsTo(Adoptiondelivery::class, 'idAdoptiondelivery');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function specialrat()
    {
        return $this->belongsTo(Specialrat::class, 'idSpecialrat');
    }
}
