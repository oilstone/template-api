<?php

return [
    'oauth' => [
        'keys' => [
            'encryption' => env('OAUTH_ENCRYPTION_KEY'),
            'public' => env('OAUTH_KEY_PATH').'/public.key',
            'private' => env('OAUTH_KEY_PATH').'/private.key',
        ],
    ],
];
