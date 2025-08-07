<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Common\CredentialsTrait;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractSipayRequest extends AbstractRequest
{
    use CredentialsTrait;

    abstract protected function getEndpoint();

    abstract protected function getResponseClass();

    protected bool $requiresAuth = true;

    protected function getBaseUrl(): string
    {
        if ($this->getTestMode()) {
            return 'https://provisioning.sipay.com.tr/ccpayment';
        }

        return 'https://app.sipay.com.tr/ccpayment';
    }

    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];
        if ($this->requiresAuth) {
            $headers['Authorization'] = 'Bearer '.$this->getBearerToken();
        }

        $httpResponse = $this->httpClient->request('POST', $this->getEndpoint(), $headers, json_encode($data));

        $statusCode = $httpResponse->getStatusCode();

        if (401 === $statusCode) {
            throw new InvalidRequestException('Unauthorized: Invalid API token.');
        }

        $responseData = json_decode($httpResponse->getBody()->getContents(), true);

        $responseClass = $this->getResponseClass();

        return $this->response = new $responseClass($this, $responseData);
    }
}
