<?php

namespace Keune\OmnipaySipay\Message\Response;

class GetEnabledInstallmentsResponse extends AbstractSipayResponse
{
    /**
     * @return int[]
     */
    public function getInstallments(): array
    {
        return $this->data['installments'];
    }
}
