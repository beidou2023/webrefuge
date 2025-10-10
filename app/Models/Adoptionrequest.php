<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoptionrequest extends Model
{
    protected $table = 'adoptionrequests';

    protected $fillable = [
        'idUser',
        'imgUrl',
        'reason',
        'experience',
        'quantityExpected',
        'couple',
        'aprovedBy',
        'contactTravel',
        'contactReturn',
        'noReturn',
        'care',
        'followUp',
        'hasPets',
        'petsInfo',
        'canPayVet',
        'status',
    ];

    protected $casts = [
        'idUser' => 'integer',
        'aprovedBy' => 'integer',
        'quantityExpected' => 'integer',
        'couple' => 'integer',
        'noReturn' => 'integer',
        'care' => 'integer',
        'followUp' => 'integer',
        'hasPets' => 'integer',
        'canPayVet' => 'integer',
        'status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'aprovedBy');
    }
}
