# Laravel Payment Integration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrfansi/payment.svg?style=flat-square)](https://packagist.org/packages/mrfansi/payment)
[![Total Downloads](https://img.shields.io/packagist/dt/mrfansi/payment.svg?style=flat-square)](https://packagist.org/packages/mrfansi/payment)

All-in-one payment gateway integration for Laravel applications. Currently supports:

- Xendit
- Midtrans
- Ipaymu

## Installation

You can install the package via composer:

```bash
composer require mrfansi/payment
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="payment-config"
```

Optionally, you can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="payment-migrations"
php artisan migrate
```

## Configuration

Add your payment gateway credentials to your `.env` file:

```env
# Default gateway and mode
PAYMENT_GATEWAY=xendit
PAYMENT_MODE=sandbox

# Default callback URLs (optional)
PAYMENT_SUCCESS_URL=https://your-app.com/payment/success
PAYMENT_FAILURE_URL=https://your-app.com/payment/failed
PAYMENT_NOTIFICATION_URL=https://your-app.com/payment/notification

# Xendit credentials
XENDIT_SANDBOX_SECRET_KEY=
XENDIT_SANDBOX_PUBLIC_KEY=
XENDIT_PRODUCTION_SECRET_KEY=
XENDIT_PRODUCTION_PUBLIC_KEY=

# Midtrans credentials
MIDTRANS_SANDBOX_SERVER_KEY=
MIDTRANS_SANDBOX_CLIENT_KEY=
MIDTRANS_SANDBOX_MERCHANT_ID=
MIDTRANS_PRODUCTION_SERVER_KEY=
MIDTRANS_PRODUCTION_CLIENT_KEY=
MIDTRANS_PRODUCTION_MERCHANT_ID=

# Ipaymu credentials
IPAYMU_SANDBOX_VA=
IPAYMU_SANDBOX_API_KEY=
IPAYMU_PRODUCTION_VA=
IPAYMU_PRODUCTION_API_KEY=
```

## Configuration

You can set default callback URLs in your config/payment.php file or .env:

```php
// config/payment.php
'callbacks' => [
    'success_url' => env('PAYMENT_SUCCESS_URL', 'https://your-app.com/payment/success'),
    'failure_url' => env('PAYMENT_FAILURE_URL', 'https://your-app.com/payment/failed'),
    'notification_url' => env('PAYMENT_NOTIFICATION_URL', 'https://your-app.com/payment/notification'),
],
```

These URLs can be overridden when creating individual payments.

## Usage

### Quick Start (Using Default Gateway)

The simplest way to use the package is with a default gateway. Just set your preferred gateway in .env:

```env
PAYMENT_GATEWAY=xendit
```

Then use it in your code:

```php
use Mrfansi\Payment\Facades\Payment;

// Create payment using default gateway
$response = Payment::createPayment([
    'amount' => 150000,
    'description' => 'Order #123',
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '081234567890'
    ]
]);

// Get payment URL based on gateway
$paymentUrl = $response->json('invoice_url'); // for Xendit
// or
$paymentUrl = $response->json('token'); // for Midtrans
// or
$paymentUrl = $response->json('url'); // for Ipaymu

// Check status
$status = Payment::getStatus('order-123');

// Cancel payment
$cancel = Payment::cancel('order-123');
```

The package will automatically:

1. Use the default gateway from your config
2. Use default callback URLs from your config
3. Handle all the API transformations based on the gateway

### Using Specific Gateway

If you need to use a specific gateway regardless of the default setting:

```php
// Using specific gateway
$response = Payment::gateway('xendit')->createPayment([
    'amount' => 100000,
    'description' => 'Payment for Order #123',
    'success_redirect_url' => 'https://yourapp.com/payment/success', // Override default callback
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '081234567890'
    ]
]);
```

### Xendit Integration

```php
$response = Payment::gateway('xendit')->createPayment([
    'reference_id' => 'order_123',
    'amount' => 150000,
    'description' => 'Payment for Order #123',
    'success_redirect_url' => 'https://yourapp.com/payment/success',
    'failure_redirect_url' => 'https://yourapp.com/payment/failed',
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '081234567890'
    ]
]);

$paymentUrl = $response->json('invoice_url');
```

### Midtrans Integration

```php
$response = Payment::gateway('midtrans')->createPayment([
    'reference_id' => 'order_123',
    'amount' => 150000,
    'description' => 'Payment for Order #123',
    'success_redirect_url' => 'https://yourapp.com/payment/success',
    'failure_redirect_url' => 'https://yourapp.com/payment/failed',
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '081234567890'
    ],
    'payment_methods' => ['credit_card', 'gopay', 'bank_transfer']
]);

$snapToken = $response->json('token');
```

### Ipaymu Integration

```php
$response = Payment::gateway('ipaymu')->createPayment([
    'reference_id' => 'order_123',
    'amount' => 150000,
    'description' => 'Payment for Order #123',
    'success_redirect_url' => 'https://yourapp.com/payment/success',
    'failure_redirect_url' => 'https://yourapp.com/payment/failed',
    'notify_url' => 'https://yourapp.com/payment/notification',
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '081234567890'
    ],
    'payment_method' => 'va', // or: 'cstore', 'banktransfer'
]);

$paymentUrl = $response->json('url');
```

### Checking Payment Status

```php
$status = Payment::gateway('xendit')->getStatus('invoice-123');
$status = Payment::gateway('midtrans')->getStatus('order-123');
$status = Payment::gateway('ipaymu')->getStatus('trx-123');
```

### Cancelling Payment

```php
$cancel = Payment::gateway('xendit')->cancel('invoice-123');
$cancel = Payment::gateway('midtrans')->cancel('order-123');
$cancel = Payment::gateway('ipaymu')->cancel('trx-123');
```

## Testing

```bash
composer test
```

## Credits

- [Muhammad Irfan](https://github.com/mrfansi)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
