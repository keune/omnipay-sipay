<?php

namespace Keune\OmnipaySipay\Message\Response;

class ThreeDSecureCompleteResponse extends AbstractSipayResponse
{
    public function getAuthCode(): ?string
    {
        return $this->sipayData['auth_code'] ?? null;
    }

    public function getHashKey(): ?string
    {
        return $this->sipayData['hash_key'] ?? null;
    }

    public function getErrorCode(): ?string
    {
        return $this->sipayData['error_code'] ?? null;
    }

    public function getErrorDescription(): ?string
    {
        return $this->sipayData['error'] ?? null;
    }

    public function getOriginalBankErrorCode(): ?string
    {
        return $this->sipayData['original_bank_error_code'] ?? null;
    }

    public function getOriginalBankErrorDescription(): ?string
    {
        return $this->sipayData['original_bank_error_description'] ?? null;
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

    public function isSuccessful(): bool
    {
        return parent::isSuccessful()
            && $this->getAuthCode()
            && isset($this->sipayData['status'])
            && 'completed' == strtolower($this->sipayData['status'])
            && 1 == $this->getPaymentStatus();
    }
}
