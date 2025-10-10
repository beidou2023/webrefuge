<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratreport extends Model
{
    protected $table = 'ratreports';

    protected $fillable = [
        'idUser',
        'idRat',
        'reviewedBy',
        'comment',
        'resolved',
        'status',
    ];

    protected $casts = [
        'idUser' => 'integer',
        'idRat' => 'integer',
        'reviewedBy' => 'integer',
        'resolved' => 'boolean',
        'status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function rat()
    {
        return $this->belongsTo(Rat::class, 'idRat');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewedBy');
    }
}
