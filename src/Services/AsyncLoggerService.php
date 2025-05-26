<?php
namespace YlLogger\AsyncLogger\Services;

use YlLogger\AsyncLogger\Jobs\WriteLogToMongoJob;
use YlLogger\AsyncLogger\Helpers\RequestId;

class AsyncLoggerService
{
    public function log(string $level, string $message, array $context = []): void
    {
        $requestId = RequestId::get();



        $logData = [
            'request_id' => $requestId,
            'level'      => $level,
            'message'    => $message,
            'context'    => $context,
        ];

        WriteLogToMongoJob::dispatch($logData)->onQueue(config('async_logger.queue'));
    }

    public function info(string $message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }
}
