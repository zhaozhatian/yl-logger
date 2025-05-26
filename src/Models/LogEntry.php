<?php
namespace YlLogger\AsyncLogger\Models;

use \MongoDB\Laravel\Eloquent\Model;


class LogEntry extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'async_logs';

    protected $fillable = [
        'request_id',
        'level',
        'message',
        'context',
        'created_at',
    ];

    public $timestamps = false;
}
