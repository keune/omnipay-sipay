<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Common\Helper;
use Keune\OmnipaySipay\Message\Response\ThreeDSecureCompleteResponse;
use Omnipay\Common\Exception\InvalidRequestException;

class ThreeDSecureCompleteRequest extends AbstractSipayRequest
{
    public function generateHashKey($merchant_key, $invoice_id, $order_id, $status): string
    {
        $data = $merchant_key.'|'.$invoice_id.'|'.$order_id.'|'.$status;

        return Helper::generateHash($data, $this->getAppSecret());
    }

    public function getStatus(): string
    {
        return $this->getParameter('status');
    }

    public function setStatus(string $status): void
    {
        $validValues = ['complete', 'cancel'];
        if (!in_array($status, $validValues)) {
            throw new InvalidRequestException('Invalid status. Valid values are '.implode(', ', $validValues));
        }

        $this->setParameter('status', $status);
    }

    public function getData()
    {
        $this->validate('transactionId', 'transactionReference', 'status');

        return [
            'merchant_key' => $this->getMerchantKey(),
            'hash_key' => $this->generateHashKey(
                $this->getMerchantKey(),
                $this->getTransactionId(),
                $this->getTransactionReference(),
                $this->getStatus()
            ),

            'invoice_id' => $this->getTransactionId(),
            'order_id' => $this->getTransactionReference(),
            'status' => $this->getStatus(),
        ];
    }

    protected function getEndpoint()
    {
        return $this->getBaseUrl().'/payment/complete';
    }

    protected function getResponseClass()
    {
        return ThreeDSecureCompleteResponse::class;
    }
}
