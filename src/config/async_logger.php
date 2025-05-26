<?php
return [
    'queue' => env('ASYNC_LOGGER_QUEUE', 'async_logger'),

    'connection' => env('ASYNC_LOGGER_CONNECTION', 'rabbitmq'),
];
