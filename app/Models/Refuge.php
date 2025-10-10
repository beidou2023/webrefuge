<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refuge extends Model
{
    protected $table = 'refuges';

    protected $fillable = [
        'idManager',
        'name',
        'address',
        'maleCount',
        'femaleCount',
        'status',
    ];

    protected $casts = [
        'idManager' => 'integer',
        'maleCount' => 'integer',
        'femaleCount' => 'integer',
        'status' => 'integer',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'idManager');
    }
}
