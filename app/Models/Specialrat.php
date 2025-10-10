<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialrat extends Model
{
    protected $table = 'specialrats';

    protected $fillable = [
        'idRefuge',
        'name',
        'description',
        'sex',
        'imgUrl',
        'status',
    ];

    protected $casts = [
        'idRefuge' => 'integer',
        'status' => 'integer',
    ];

    // Relación con refugio
    public function refuge()
    {
        return $this->belongsTo(Refuge::class, 'idRefuge');
    }
}
