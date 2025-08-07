<?php

namespace Keune\OmnipaySipay\Message\Response;

use Keune\OmnipaySipay\Message\Model\BearerTokenData;

class GetBearerTokenResponse extends AbstractSipayResponse
{
    public function getTokenData(): BearerTokenData
    {
        return new BearerTokenData($this->sipayData);
    }
}
