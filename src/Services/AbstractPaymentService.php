<?php

namespace Mrfansi\Payment\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Mrfansi\Payment\Contracts\PaymentServiceInterface;

abstract class AbstractPaymentService implements PaymentServiceInterface
{
    /**
     * Base URL for the payment gateway API
     */
    protected string $baseUrl;

    /**
     * Gateway configuration
     */
    protected array $config;

    /**
     * Current mode (sandbox/production)
     */
    protected string $mode = 'sandbox';

    public function __construct()
    {
        $this->mode = config('payment.mode', 'sandbox');
        $this->setupBaseUrl();
        $this->config = $this->getConfig();
    }

    /**
     * Set up the base URL for the payment gateway
     */
    abstract protected function setupBaseUrl(): void;

    /**
     * Set up headers for API requests
     *
     * @return array
     */
    abstract protected function setupHeaders(): array;

    /**
     * Get configuration for the current gateway and mode
     */
    protected function getConfig(): array
    {
        $gateway = strtolower(class_basename(static::class));
        $gateway = str_replace('service', '', $gateway);

        return config("payment.gateways.{$gateway}.{$this->mode}", []);
    }

    /**
     * Make an HTTP request to the payment gateway
     */
    protected function request(string $method, string $endpoint, array $data = []): Response
    {
        return Http::withHeaders($this->setupHeaders())
                    ->baseUrl($this->baseUrl)
            ->{strtolower($method)}($endpoint, $data);
    }

    /**
     * Set the gateway mode (sandbox/production)
     */
    public function setMode(string $mode): self
    {
        $this->mode = $mode;
        $this->setupBaseUrl();
        $this->config = $this->getConfig();

        return $this;
    }
}