<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallBackLog extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'callback_logs';

    protected $fillable = [
        'status',
        'result',
        'incoming_log_id',
    ];

    public function incomingLog(): BelongsTo
    {
        return $this->belongsTo(IncomingLog::class);
    }
}
