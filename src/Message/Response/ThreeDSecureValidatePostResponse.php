<?php

namespace Keune\OmnipaySipay\Message\Response;

use Omnipay\Common\Message\AbstractResponse;

class ThreeDSecureValidatePostResponse extends AbstractResponse
{
    public function getPostData(string $key): ?string
    {
        return $this->data['postData'][$key] ?? null;
    }

    public function getDecryptedHashData(): array
    {
        return $this->data['decryptedHashData'];
    }

    public function getMdStatus(): int
    {
        return preg_match('/^\d$/', $this->getPostData('md_status')) ? intval($this->getPostData('md_status')) : 0;
    }

    public function getErrorCode(): string
    {
        return $this->getPostData('error_code');
    }

    public function getErrorDescription(): string
    {
        return $this->getPostData('error');
    }

    public function getOriginalBankErrorCode(): string
    {
        return $this->getPostData('original_bank_error_code');
    }

    public function getOriginalBankErrorDescription(): string
    {
        return $this->getPostData('original_bank_error_description');
    }

    public function getTransactionId(): string
    {
        return $this->getPostData('invoice_id');
    }

    public function getTransactionType(): string
    {
        return $this->getPostData('transaction_type');
    }

    public function getTransactionReference(): string
    {
        return $this->getPostData('order_id');
    }

    public function getAmount(): string
    {
        return $this->getPostData('amount');
    }

    public function isMdStatusValid(array $validValues = [1]): bool
    {
        return in_array($this->getMdStatus(), $validValues);
    }

    public function isAmountValid(): bool
    {
        return $this->getDecryptedHashData()[1] == $this->data['originalAmount'];
    }

    public function isTransactionIdValid(): bool
    {
        return $this->getDecryptedHashData()[2] == $this->data['originalTransactionId'];
    }

    public function isSuccessful(): bool
    {
        return $this->isMdStatusValid()
            && $this->isAmountValid()
            && $this->isTransactionIdValid();
    }
}
