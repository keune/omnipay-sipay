<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Common\Helper;
use Keune\OmnipaySipay\Message\Response\ThreeDSecureValidatePostResponse;
use Omnipay\Common\Exception\InvalidRequestException;

class ThreeDSecureValidatePostRequest extends AbstractSipayRequest
{
    public function getPostData(): array
    {
        return $this->getParameter('postData');
    }

    public function setPostData(array $postData): void
    {
        $this->setParameter('postData', $postData);
    }

    public function getOriginalAmount(): string
    {
        return $this->getParameter('originalAmount');
    }

    public function setOriginalAmount(string $originalAmount): void
    {
        $this->setParameter('originalAmount', $originalAmount);
    }

    public function getOriginalTransactionId(): string
    {
        return $this->getParameter('originalTransactionId');
    }

    public function setOriginalTransactionId(string $originalTransactionId): void
    {
        $this->setParameter('originalTransactionId', $originalTransactionId);
    }

    public function getData()
    {
        $this->validate('postData', 'originalAmount', 'originalTransactionId');

        $requiredKeys = [
            'order_id',
            'invoice_id',
            'amount',
            'hash_key',
            'md_status',
        ];
        foreach ($requiredKeys as $key) {
            if (!isset($this->getParameter('postData')[$key]) || null === $this->getParameter('postData')[$key]) {
                throw new InvalidRequestException(sprintf('Missing the required %s parameter in postData.', $key));
            }
        }

        $decryptedHashData = Helper::validateHashKey($this->getParameter('postData')['hash_key'], $this->getAppSecret());

        return [
            'postData' => $this->getParameter('postData'),
            'originalAmount' => $this->getParameter('originalAmount'),
            'originalTransactionId' => $this->getParameter('originalTransactionId'),
            'decryptedHashData' => $decryptedHashData,
        ];
    }

    protected function getEndpoint()
    {
        return '';
    }

    protected function getResponseClass()
    {
        return ThreeDSecureValidatePostResponse::class;
    }

    public function sendData($data)
    {
        // no request will be made to sipay
        $class = $this->getResponseClass();

        return $this->response = new $class($this, $data);
    }
}
