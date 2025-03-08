<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallBackLog extends Model
{
    protected $fillable = [
        'status',
        'result',
        'incoming_log_id',
    ];
}
