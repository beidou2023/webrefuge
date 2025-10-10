<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoptiondelivery extends Model
{
    protected $table = 'adoptiondeliveries';

    protected $fillable = [
        'deliveredBy',
        'idAdoptionrequest',
        'maleCount',
        'femaleCount',
        'status',
    ];

    protected $casts = [
        'deliveredBy' => 'integer',
        'idAdoptionrequest' => 'integer',
        'maleCount' => 'integer',
        'femaleCount' => 'integer',
        'status' => 'integer',
    ];

    public function deliveryUser()
    {
        return $this->belongsTo(User::class, 'deliveredBy');
    }

    public function adoptionRequest()
    {
        return $this->belongsTo(Adoptionrequest::class, 'idAdoptionrequest');
    }
}
