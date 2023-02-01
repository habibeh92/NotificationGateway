<?php

return [
    'default' => env('NOTIFICATION_DRIVER', 'kavenegar'),

    'drivers' => [
        'ghasedak' => [
            "class"  => \App\NotificationDrivers\GhasedakDriver::class,
            'url'    => "http://api.iransmsservice.com/v2/sms/send",
            'apikey' => env("GHASEDAK_API_KEY"),
            'sender' => env("GHASEDAK_SENDER"),
        ],

        'kavenegar' => [
            "class"  => \App\NotificationDrivers\KavenegarDriver::class,
            'sender' => env("KAVENEGAR_SENDER"),
            'apikey' => env("KAVENEGAR_API_KEY"),
        ],
    ],

];
