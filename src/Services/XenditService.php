<?php

namespace Mrfansi\Payment\Services;

use Illuminate\Http\Client\Response;

class XenditService extends AbstractPaymentService
{
    /**
     * Set up the base URL for Xendit's API
     */
    protected function setupBaseUrl(): void
    {
        // Xendit uses the same base URL for both sandbox and production
        $this->baseUrl = 'https://api.xendit.co';
    }

    /**
     * Set up headers for Xendit API requests
     */
    protected function setupHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->config['secret_key'] . ':'),
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * Create a new payment invoice via Xendit
     */
    public function createPayment(array $data): Response
    {
        $callbacks = $this->getCallbackUrls($data);

        $payload = [
            'external_id' => $data['reference_id'] ?? uniqid('xnd_', true),
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
            'invoice_duration' => $data['duration'] ?? 86400, // 24 hours
            'success_redirect_url' => $callbacks['success_redirect_url'],
            'failure_redirect_url' => $callbacks['failure_redirect_url'],
            'payment_methods' => $data['payment_methods'] ?? null,
            'currency' => $data['currency'] ?? 'IDR',
            'customer' => [
                'email' => $data['customer']['email'] ?? null,
                'given_names' => $data['customer']['name'] ?? null,
                'mobile_number' => $data['customer']['phone'] ?? null,
            ]
        ];

        return $this->request('POST', '/v2/invoices', array_filter($payload));
    }

    /**
     * Get payment status from Xendit
     */
    public function getStatus(string $referenceId): Response
    {
        return $this->request('GET', "/v2/invoices/{$referenceId}");
    }

    /**
     * Cancel payment invoice in Xendit
     */
    public function cancel(string $referenceId): Response
    {
        return $this->request('POST', "/v2/invoices/{$referenceId}/expire!");
    }
}