<?php

namespace Keune\OmnipaySipay\Message\Response;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class ThreeDSecureInitResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful(): bool
    {
        return false;
    }

    public function isRedirect(): bool
    {
        return true;
    }

    public function getRedirectMethod(): string
    {
        return 'POST';
    }

    public function getRedirectUrl()
    {
        return $this->data['redirectUrl'];
    }

    public function getRedirectData()
    {
        return $this->data['form'];
    }
}
