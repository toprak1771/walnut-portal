<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomingLogData extends Model
{
    use HasFactory;

    protected $fillable = [
        'payload',
        'inserted',
    ];
}
