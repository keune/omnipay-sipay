<?php

namespace Keune\OmnipaySipay\Message\Model;

class InstallmentOption extends AbstractModel
{
    public function getTitle(): string
    {
        return $this->get('title');
    }

    public function getInstallmentsNumber(): int
    {
        return (int) $this->get('installments_number', 1);
    }

    public function getCardScheme(): ?string
    {
        return $this->get('card_scheme');
    }

    public function getCardBank(): ?string
    {
        return $this->get('card_bank');
    }

    public function isCommercial(): bool
    {
        return 'TRUE' === strtoupper($this->get('is_commercial'));
    }

    public function getPayableAmount(): float
    {
        return (float) $this->get('payable_amount', 0);
    }

    public function getCurrencyCode(): string
    {
        return $this->get('currency_code');
    }

    public function getBankCode(): string
    {
        return $this->get('bank_code');
    }
}
