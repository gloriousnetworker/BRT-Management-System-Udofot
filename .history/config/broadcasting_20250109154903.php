<?php

return [

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    'connections' => [
    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ],
    ],

        'log' => [
            'driver' => 'log',
            'level' => 'debug', // You can set the logging level here
        ],

        'null' => [
            'driver' => 'null', // When you don't want to broadcast, for testing purposes.
        ],

    ],

];
