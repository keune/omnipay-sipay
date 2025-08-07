<?php

namespace Keune\OmnipaySipay\Message\Response;

class StandardPurchaseResponse extends AbstractSipayResponse
{
    public function getAuthCode(): string
    {
        return $this->sipayData['auth_code'];
    }

    public function getHashKey(): string
    {
        return $this->sipayData['hash_key'];
    }

    public function getOriginalBankErrorCode(): string
    {
        return $this->sipayData['original_bank_error_code'];
    }

    public function getOriginalBankErrorDescription(): string
    {
        return $this->sipayData['original_bank_error_description'];
    }

    public function getPaymentStatus(): int
    {
        return $this->sipayData['payment_status'];
    }

    public function getTransactionId(): int
    {
        return $this->sipayData['invoice_id'];
    }

    public function getTransactionReference(): string
    {
        return $this->sipayData['order_id'];
    }
}
