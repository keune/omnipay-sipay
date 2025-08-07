<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Message\Response\GetMerchantCommissionsResponse;

class GetMerchantCommissionsRequest extends AbstractSipayRequest
{
    public function getData()
    {
        return [
            'currency_code' => $this->getCurrency(),
            'commission_by' => 'merchant',
        ];
    }

    protected function getEndpoint()
    {
        return $this->getBaseUrl().'/api/commissions';
    }

    protected function getResponseClass()
    {
        return GetMerchantCommissionsResponse::class;
    }
}
