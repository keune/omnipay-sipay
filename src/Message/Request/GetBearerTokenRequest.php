<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Message\Response\GetBearerTokenResponse;

class GetBearerTokenRequest extends AbstractSipayRequest
{
    protected bool $requiresAuth = false;

    public function getData()
    {
        return [
            'app_id' => $this->getAppKey(),
            'app_secret' => $this->getAppSecret(),
        ];
    }

    protected function getEndpoint()
    {
        return $this->getBaseUrl().'/api/token';
    }

    protected function getResponseClass()
    {
        return GetBearerTokenResponse::class;
    }
}
