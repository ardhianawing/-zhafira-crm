<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VAPID Keys
    |--------------------------------------------------------------------------
    |
    | Generate keys at: https://web-push-codelab.glitch.me/
    | Or run: ./vendor/bin/webpush-generate-keys
    |
    */

    'public_key' => env('VAPID_PUBLIC_KEY'),
    'private_key' => env('VAPID_PRIVATE_KEY'),
];
