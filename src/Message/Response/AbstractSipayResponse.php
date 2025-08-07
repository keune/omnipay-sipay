<?php

namespace Keune\OmnipaySipay\Message\Response;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractSipayResponse extends AbstractResponse
{
    protected ?array $sipayData;

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->sipayData = $data['data'] ?? [];
    }

    public function isSuccessful(): bool
    {
        return isset($this->data['status_code'])
            && 100 === $this->data['status_code'];
    }

    public function getMessage(): string
    {
        return $this->data['status_description'] ?? '';
    }

    public function getCode(): string
    {
        return $this->data['status_code'] ?? '';
    }

    public function getSipayData(): ?array
    {
        return $this->sipayData;
    }
}
