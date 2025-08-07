<?php

namespace Keune\OmnipaySipay\Message\Response;

class RefundResponse extends AbstractSipayResponse
{
    public function isSuccessful(): bool
    {
        return isset($this->data['status_code'])
            && (100 === $this->data['status_code'] || 101 === $this->data['status_code']);
    }

    public function getTransactionReference(): string
    {
        return $this->data['ref_no'];
    }

    public function getTransactionId(): string
    {
        return $this->data['invoice_id'];
    }

    public function getOrderNo(): string
    {
        return $this->data['order_no'];
    }
}
