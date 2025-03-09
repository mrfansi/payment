<?php

namespace Mrfansi\Payment;

use InvalidArgumentException;
use Mrfansi\Payment\Contracts\PaymentServiceInterface;
use Mrfansi\Payment\Services\IpaymuService;
use Mrfansi\Payment\Services\MidtransService;
use Mrfansi\Payment\Services\XenditService;

class Payment
{
    /**
     * Available payment gateways
     */
    protected array $gateways = [
        'xendit' => XenditService::class,
        'midtrans' => MidtransService::class,
        'ipaymu' => IpaymuService::class,
    ];

    /**
     * Active payment gateway instances
     */
    protected array $instances = [];

    /**
     * Get payment gateway instance
     */
    public function gateway(string $name): PaymentServiceInterface
    {
        $name = strtolower($name);

        if (! isset($this->gateways[$name])) {
            throw new InvalidArgumentException("Payment gateway [{$name}] not supported.");
        }

        if (! isset($this->instances[$name])) {
            $class = $this->gateways[$name];
            $this->instances[$name] = new $class;
        }

        return $this->instances[$name];
    }

    /**
     * Get default payment gateway instance
     */
    public function getDefaultGateway(): PaymentServiceInterface
    {
        $default = config('payment.default', 'xendit');

        return $this->gateway($default);
    }

    /**
     * Dynamically call methods on the default gateway
     */
    public function __call(string $method, array $parameters)
    {
        return $this->getDefaultGateway()->$method(...$parameters);
    }
}
