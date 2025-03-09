<?php

namespace Mrfansi\Payment\Services;

use Illuminate\Http\Client\Response;

class MidtransService extends AbstractPaymentService
{
    /**
     * Set up the base URL for Midtrans's API
     */
    protected function setupBaseUrl(): void
    {
        $this->baseUrl = $this->mode === 'production'
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    /**
     * Set up headers for Midtrans API requests
     */
    protected function setupHeaders(): array
    {
        return [
            'Authorization' => 'Basic '.base64_encode($this->config['server_key'].':'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Create a new payment transaction via Midtrans Snap
     */
    public function createPayment(array $data): Response
    {
        $callbacks = $this->getCallbackUrls($data);

        $payload = [
            'transaction_details' => [
                'order_id' => $data['reference_id'] ?? uniqid('mdt_', true),
                'gross_amount' => $data['amount'],
            ],
            'customer_details' => [
                'first_name' => $data['customer']['name'] ?? null,
                'email' => $data['customer']['email'] ?? null,
                'phone' => $data['customer']['phone'] ?? null,
            ],
            'enabled_payments' => $data['payment_methods'] ?? [],
            'credit_card' => [
                'secure' => true,
            ],
            'expiry' => [
                'duration' => $data['duration'] ?? 24,
                'unit' => 'hour',
            ],
            'callbacks' => [
                'finish' => $callbacks['success_redirect_url'],
                'error' => $callbacks['failure_redirect_url'],
            ],
        ];

        return $this->request('POST', '/transactions', array_filter($payload, function ($value) {
            return ! is_null($value) && (! is_array($value) || ! empty(array_filter($value)));
        }));
    }

    /**
     * Get payment status from Midtrans
     */
    public function getStatus(string $referenceId): Response
    {
        return $this->request('GET', "/transactions/{$referenceId}/status");
    }

    /**
     * Cancel payment transaction in Midtrans
     */
    public function cancel(string $referenceId): Response
    {
        return $this->request('POST', "/transactions/{$referenceId}/cancel");
    }
}
