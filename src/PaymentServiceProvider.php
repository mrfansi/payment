<?php

namespace Mrfansi\Payment;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PaymentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('payment')
            ->hasConfigFile()
            ->hasMigration('create_payment_table');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Payment::class, function ($app) {
            return new Payment();
        });

        $this->app->alias(Payment::class, 'payment');
    }

    public function provides(): array
    {
        return [
            Payment::class,
            'payment',
        ];
    }
}