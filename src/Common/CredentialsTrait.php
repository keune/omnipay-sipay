<?php

namespace Keune\OmnipaySipay\Common;

trait CredentialsTrait
{
    public function getBearerToken(): string
    {
        return $this->getParameter('bearerToken');
    }

    public function setBearerToken(string $bearerToken): void
    {
        $this->setParameter('bearerToken', $bearerToken);
    }

    public function getBearerTokenIs3d(): int
    {
        return $this->getParameter('bearerTokenIs3d');
    }

    public function setBearerTokenIs3d(int $value): void
    {
        $this->setParameter('bearerTokenIs3d', $value);
    }

    public function getAppKey(): ?string
    {
        return $this->getParameter('appKey');
    }

    public function setAppKey(string $appKey): void
    {
        $this->setParameter('appKey', $appKey);
    }

    public function getAppSecret(): string
    {
        return $this->getParameter('appSecret');
    }

    public function setAppSecret(string $appSecret): void
    {
        $this->setParameter('appSecret', $appSecret);
    }

    public function getMerchantKey(): ?string
    {
        return $this->getParameter('merchantKey');
    }

    public function setMerchantKey(string $merchantKey): void
    {
        $this->setParameter('merchantKey', $merchantKey);
    }

    public function getMerchantId(): int
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId(int $merchantId): void
    {
        $this->setParameter('merchantId', $merchantId);
    }
}
