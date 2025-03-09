<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment gateway that will be used when
    | a specific gateway is not explicitly specified.
    |
    */
    'default' => env('PAYMENT_GATEWAY', 'xendit'),

    /*
    |--------------------------------------------------------------------------
    | Payment Mode
    |--------------------------------------------------------------------------
    |
    | This option controls whether to use sandbox or production credentials
    | for payment gateways.
    |
    | Supported: "sandbox", "production"
    |
    */
    'mode' => env('PAYMENT_MODE', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Callback URLs
    |--------------------------------------------------------------------------
    |
    | Configure the default callback URLs for payment notifications.
    | These URLs can be overridden when creating payments.
    |
    */
    'callbacks' => [
        'success_url' => env('PAYMENT_SUCCESS_URL', 'https://your-app.com/payment/success'),
        'failure_url' => env('PAYMENT_FAILURE_URL', 'https://your-app.com/payment/failed'),
        'notification_url' => env('PAYMENT_NOTIFICATION_URL', 'https://your-app.com/payment/notification'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Gateways
    |--------------------------------------------------------------------------
    |
    | Here you may configure the payment gateways for your application.
    | Each gateway can have separate sandbox and production credentials.
    |
    */
    'gateways' => [
        'xendit' => [
            'sandbox' => [
                'secret_key' => env('XENDIT_SANDBOX_SECRET_KEY'),
                'public_key' => env('XENDIT_SANDBOX_PUBLIC_KEY'),
            ],
            'production' => [
                'secret_key' => env('XENDIT_PRODUCTION_SECRET_KEY'),
                'public_key' => env('XENDIT_PRODUCTION_PUBLIC_KEY'),
            ],
        ],

        'midtrans' => [
            'sandbox' => [
                'server_key' => env('MIDTRANS_SANDBOX_SERVER_KEY'),
                'client_key' => env('MIDTRANS_SANDBOX_CLIENT_KEY'),
                'merchant_id' => env('MIDTRANS_SANDBOX_MERCHANT_ID'),
            ],
            'production' => [
                'server_key' => env('MIDTRANS_PRODUCTION_SERVER_KEY'),
                'client_key' => env('MIDTRANS_PRODUCTION_CLIENT_KEY'),
                'merchant_id' => env('MIDTRANS_PRODUCTION_MERCHANT_ID'),
            ],
        ],

        'ipaymu' => [
            'sandbox' => [
                'va' => env('IPAYMU_SANDBOX_VA'),
                'api_key' => env('IPAYMU_SANDBOX_API_KEY'),
            ],
            'production' => [
                'va' => env('IPAYMU_PRODUCTION_VA'),
                'api_key' => env('IPAYMU_PRODUCTION_API_KEY'),
            ],
        ],
    ],
];
