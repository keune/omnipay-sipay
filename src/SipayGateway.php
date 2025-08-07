<?php

namespace Keune\OmnipaySipay;

use Keune\OmnipaySipay\Common\CredentialsTrait;
use Keune\OmnipaySipay\Message\Request\FetchTransactionRequest;
use Keune\OmnipaySipay\Message\Request\GetBearerTokenRequest;
use Keune\OmnipaySipay\Message\Request\GetEnabledInstallmentsRequest;
use Keune\OmnipaySipay\Message\Request\GetInstallmentsRequest;
use Keune\OmnipaySipay\Message\Request\GetMerchantCommissionsRequest;
use Keune\OmnipaySipay\Message\Request\RefundRequest;
use Keune\OmnipaySipay\Message\Request\StandardPurchaseRequest;
use Keune\OmnipaySipay\Message\Request\ThreeDSecureCompleteRequest;
use Keune\OmnipaySipay\Message\Request\ThreeDSecureInitRequest;
use Keune\OmnipaySipay\Message\Request\ThreeDSecureValidatePostRequest;
use Keune\OmnipaySipay\Message\Response\ThreeDSecureValidatePostResponse;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;

class SipayGateway extends AbstractGateway
{
    use CredentialsTrait;

    public function initialize(array $parameters = []): self
    {
        parent::initialize($parameters);

        return $this;
    }

    public function getName(): string
    {
        return 'Sipay';
    }

    public function getDefaultParameters(): array
    {
        return [
            'testMode' => true,
            'merchantKey' => $this->getMerchantKey(),
        ];
    }

    public function fetchBearerToken(): AbstractRequest
    {
        return $this->createRequest(GetBearerTokenRequest::class, []);
    }

    public function purchase(array $options = []): AbstractRequest
    {
        $class = isset($options['use3DSecure']) && $options['use3DSecure']
            ? ThreeDSecureInitRequest::class
            : StandardPurchaseRequest::class;

        return $this->createRequest($class, $options);
    }

    public function validateTdsPostData(array $options = []): ThreeDSecureValidatePostResponse
    {
        $req = $this->createRequest(ThreeDSecureValidatePostRequest::class, $options);
        return $req->send();
    }

    public function completePurchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(ThreeDSecureCompleteRequest::class, $options);
    }

    public function getInstallments(array $options = []): AbstractRequest
    {
        return $this->createRequest(GetInstallmentsRequest::class, $options);
    }

    public function getMerchantCommissions(array $options = []): AbstractRequest
    {
        return $this->createRequest(GetMerchantCommissionsRequest::class, $options);
    }

    public function getEnabledInstallments(): AbstractRequest
    {
        return $this->createRequest(GetEnabledInstallmentsRequest::class, []);
    }

    public function fetchTransaction(array $options = []): AbstractRequest
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }

    public function refund(array $options = []): AbstractRequest
    {
        return $this->createRequest(RefundRequest::class, $options);
    }
}
