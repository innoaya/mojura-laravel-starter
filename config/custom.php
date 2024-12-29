<?php

return [
    'basic_auth' => [
        'username' => env('WEB_BASIC_AUTH_USERNAME', 'telescope'),
        'password' => env('WEB_BASIC_AUTH_PASSWORD', 'telescope'),
    ],
    'setting' => [
        'max_login_fails' => env('MAX_LOGIN_FAILS', 5),
        'failed_login_retry_minutes' => env('FAILED_LOGIN_RETRY_MINUTES', 15),
    ],
];
