<?php
namespace YlLogger\AsyncLogger;

use Illuminate\Support\ServiceProvider;

class AsyncLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/async_logger.php' => config_path('async_logger.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/async_logger.php', 'async_logger');

        $this->app->singleton('asynclogger', function ($app) {
            return new Services\AsyncLoggerService();
        });
    }
}
