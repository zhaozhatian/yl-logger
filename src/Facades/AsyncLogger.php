<?php
namespace YlLogger\AsyncLogger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static void info(string $message, array $context = [])
 * @method static void error(string $message, array $context = [])
 * @method static void debug(string $message, array $context = [])
 */
class AsyncLogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'asynclogger';
    }
}
