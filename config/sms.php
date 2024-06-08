<?php

return [
    'driver' => env('SMS_DRIVER', null),
    'drivers' => [
        'PlayMobile' => [
            'class' => App\Drivers\Sms\PlayMobile::class,
            'endpoint' => env('PLAYMOBILE_ENDPOINT'),
            'login' => env('PLAYMOBILE_LOGIN'),
            'password' => env('PLAYMOBILE_PASSWORD')
        ]
    ]
];
