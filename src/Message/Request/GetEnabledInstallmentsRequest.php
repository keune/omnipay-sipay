<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Message\Response\GetEnabledInstallmentsResponse;

class GetEnabledInstallmentsRequest extends AbstractSipayRequest
{
    public function getData()
    {
        return [
            'merchant_key' => $this->getMerchantKey(),
        ];
    }

    protected function getEndpoint()
    {
        return $this->getBaseUrl().'/api/installments';
    }

    protected function getResponseClass()
    {
        return GetEnabledInstallmentsResponse::class;
    }
}
