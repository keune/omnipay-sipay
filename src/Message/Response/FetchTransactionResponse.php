<?php

namespace Keune\OmnipaySipay\Message\Response;

class FetchTransactionResponse extends AbstractSipayResponse
{
    public function getTransactionStatus(): string
    {
        return $this->data['transaction_status'];
    }

    public function getTotalRefundedAmount(): float
    {
        return $this->data['total_refunded_amount'];
    }
}
