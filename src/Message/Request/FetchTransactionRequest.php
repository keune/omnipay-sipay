<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Common\Helper;
use Keune\OmnipaySipay\Message\Response\FetchTransactionResponse;

class FetchTransactionRequest extends AbstractSipayRequest
{
    public function generateHashKey($invoice_id, $merchant_key)
    {
        $data = $invoice_id.'|'.$merchant_key;

        return Helper::generateHash($data, $this->getAppSecret());
    }

    public function getInvoiceId(): string
    {
        return $this->getParameter('invoiceId');
    }

    public function setInvoiceId(string $invoiceId)
    {
        $this->setParameter('invoiceId', $invoiceId);
    }

    public function getIncludePendingStatus(): ?bool
    {
        return $this->getParameter('includePendingStatus');
    }

    public function setIncludePendingStatus(bool $includePendingStatus)
    {
        $this->setParameter('includePendingStatus', $includePendingStatus);
    }

    public function getData()
    {
        $this->validate('invoiceId');

        $data = [
            'merchant_key' => $this->getMerchantKey(),
            'invoice_id' => $this->getInvoiceId(),
            'hash_key' => $this->generateHashKey($this->getInvoiceId(), $this->getMerchantKey()),
        ];

        if (null !== $this->getIncludePendingStatus()) {
            $data['include_pending_status'] = $this->getIncludePendingStatus();
        }

        return $data;
    }

    protected function getEndpoint()
    {
        return $this->getBaseUrl().'/api/checkstatus';
    }

    protected function getResponseClass()
    {
        return FetchTransactionResponse::class;
    }
}
