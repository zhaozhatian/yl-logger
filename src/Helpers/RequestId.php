<?php
namespace YlLogger\AsyncLogger\Helpers;

use Illuminate\Support\Str;

class RequestId
{
    protected static ?string $requestId = null;

    public static function get(): string
    {
        if (static::$requestId === null) {
            static::$requestId = (string) Str::uuid();
        }
        return static::$requestId;
    }
}
