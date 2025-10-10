<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    protected $table = 'arrivals';

    protected $fillable = [
        'maleCount',
        'femaleCount',
        'origin',
        'notes',
        'idRefuge',
        'status',
    ];

    protected $casts = [
        'maleCount' => 'integer',
        'femaleCount' => 'integer',
        'idRefuge' => 'integer',
        'status' => 'integer',
    ];

    public function refuge()
    {
        return $this->belongsTo(Refuge::class, 'idRefuge');
    }
}
