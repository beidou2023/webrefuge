<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = false;

    protected $table = 'logs';

    protected $fillable = [
        'performedBy',
        'tableName',
        'crud',
        'detail',
        'created_at',
    ];
}
