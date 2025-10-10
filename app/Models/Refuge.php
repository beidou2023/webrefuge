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

    public function specialrats()
    {
        return $this->hasMany(Specialrat::class, 'idRefuge');
    }

    public function arrivals()
    {
        return $this->hasMany(Arrival::class, 'idRefuge');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getTotalRatsAttribute()
    {
        return $this->maleCount + $this->femaleCount;
    }

    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'Activo' : 'Inactivo';
    }
}
