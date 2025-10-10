<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialrat extends Model
{
    use HasFactory;

    protected $table = 'specialrats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'idRefuge',
        'name',
        'description', 
        'sex',
        'imgUrl',
        'status'
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ADOPTED = 2;

    public function refuge()
    {
        return $this->belongsTo(Refuge::class, 'idRefuge');
    }

    public function rat()
    {
        return $this->hasOne(Rat::class, 'idSpecialrat');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }
}