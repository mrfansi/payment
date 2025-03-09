<?php

namespace Mrfansi\Payment\Facades;

use Illuminate\Support\Facades\Facade;
use Mrfansi\Payment\Contracts\PaymentServiceInterface;

/**
 * @method static PaymentServiceInterface gateway(string $name)
 * @method static PaymentServiceInterface getDefaultGateway()
 * @method static \Illuminate\Http\Client\Response createPayment(array $data)
 * @method static \Illuminate\Http\Client\Response getStatus(string $referenceId)
 * @method static \Illuminate\Http\Client\Response cancel(string $referenceId)
 *
 * @see \Mrfansi\Payment\Payment
 */
class Payment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'payment';
    }
}