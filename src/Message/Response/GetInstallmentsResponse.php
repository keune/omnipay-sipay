<?php

namespace Keune\OmnipaySipay\Message\Response;

use Keune\OmnipaySipay\Message\Model\InstallmentOption;

class GetInstallmentsResponse extends AbstractSipayResponse
{
    /**
     * @return InstallmentOption[]
     */
    public function getInstallments(): array
    {
        return array_map(fn ($item) => new InstallmentOption($item), $this->sipayData);
    }
}
