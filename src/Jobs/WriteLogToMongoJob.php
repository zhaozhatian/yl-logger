<?php
namespace YlLogger\AsyncLogger\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use YlLogger\AsyncLogger\Models\LogEntry;

class WriteLogToMongoJob implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected array $logData;

    public function __construct(array $logData)
    {
        $this->logData = $logData;
    }

    public function handle()
    {
        LogEntry::create([
            'request_id' => $this->logData['request_id'] ?? null,
            'level'      => $this->logData['level'] ?? 'info',
            'message'    => $this->logData['message'] ?? '',
            'context'    => $this->logData['context'] ?? [],
            'created_at' => now(),
        ]);
    }
}
