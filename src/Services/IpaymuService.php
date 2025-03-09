<?php

namespace Mrfansi\Payment\Services;

use Illuminate\Http\Client\Response;

class IpaymuService extends AbstractPaymentService
{
    /**
     * Set up the base URL for Ipaymu's API
     */
    protected function setupBaseUrl(): void
    {
        $this->baseUrl = $this->mode === 'production'
            ? 'https://my.ipaymu.com/api/v2'
            : 'https://sandbox.ipaymu.com/api/v2';
    }

    /**
     * Set up headers for Ipaymu API requests
     */
    protected function setupHeaders(): array
    {
        $timestamp = date('YmdHis');
        $signature = hash('sha256', $this->config['va'] . ':' . $timestamp . ':' . $this->config['api_key']);

        return [
            'Content-Type' => 'application/json',
            'va' => $this->config['va'],
            'signature' => $signature,
            'timestamp' => $timestamp
        ];
    }

    /**
     * Create a new payment transaction via Ipaymu
     */
    public function createPayment(array $data): Response
    {
        $payload = [
            'reference_id' => $data['reference_id'] ?? uniqid('ipm_', true),
            'product' => [$data['description'] ?? 'Payment'],
            'qty' => [1],
            'price' => [$data['amount']],
            'amount' => $data['amount'],
            'return_url' => $data['success_redirect_url'] ?? null,
            'cancel_url' => $data['failure_redirect_url'] ?? null,
            'notify_url' => $data['notify_url'] ?? null,
            'buyerName' => $data['customer']['name'] ?? null,
            'buyerEmail' => $data['customer']['email'] ?? null,
            'buyerPhone' => $data['customer']['phone'] ?? null,
            'expired' => $data['duration'] ?? 24, // hours
            'paymentMethod' => $data['payment_method'] ?? null,
            'paymentChannel' => $data['payment_channel'] ?? null
        ];

        return $this->request('POST', '/payment/direct', array_filter($payload));
    }

    /**
     * Get payment status from Ipaymu
     */
    public function getStatus(string $referenceId): Response
    {
        return $this->request('POST', '/payment/status', [
            'transactionId' => $referenceId
        ]);
    }

    /**
     * Cancel payment transaction in Ipaymu
     */
    public function cancel(string $referenceId): Response
    {
        return $this->request('POST', '/payment/cancel', [
            'transactionId' => $referenceId
        ]);
    }
}