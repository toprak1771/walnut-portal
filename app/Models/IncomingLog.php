<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomingLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'incoming_logs';

    protected $fillable = [
        'source',
        'title',
        'word_count',
        'incoming_log_data_id',
    ];

    public function incomingLogData():BelongsTo {
        return $this->belongsTo(IncomingLogData::class);
    }
}
