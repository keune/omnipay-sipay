<?php

namespace Keune\OmnipaySipay\Message\Model;

class BearerTokenData extends AbstractModel
{
    public function getToken(): string
    {
        return $this->get('token');
    }

    public function getIs3d(): int
    {
        return $this->get('is_3d');
    }

    public function getExpiresAt(): string
    {
        return $this->get('expires_at');
    }
}