<?php

namespace Mrfansi\Payment\Contracts;

use Illuminate\Http\Client\Response;

interface PaymentServiceInterface
{
    /**
     * Create a new payment
     *
     * @param array $data Payment data
     * @return Response
     */
    public function createPayment(array $data): Response;

    /**
     * Get payment status
     *
     * @param string $referenceId Payment reference ID
     * @return Response
     */
    public function getStatus(string $referenceId): Response;

    /**
     * Cancel payment
     *
     * @param string $referenceId Payment reference ID
     * @return Response
     */
    public function cancel(string $referenceId): Response;

    /**
     * Set payment gateway mode
     *
     * @param string $mode Either 'sandbox' or 'production'
     * @return self
     */
    public function setMode(string $mode): self;
}