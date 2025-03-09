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
