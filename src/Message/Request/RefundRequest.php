<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Message\Response\RefundResponse;

class RefundRequest extends AbstractSipayRequest
{
    public function getInvoiceId()
    {
        return $this->getParameter('invoiceId');
    }

    public function setInvoiceId($invoiceId)
    {
        $this->setParameter('invoiceId', $invoiceId);
    }

    public function getRefundWebHookKey()
    {
        return $this->getParameter('refundWebHookKey');
    }

    public function setRefundWebHookKey($refundWebHookKey)
    {
        $this->setParameter('refundWebHookKey', $refundWebHookKey);
    }

    public function getData()
    {
        $this->validate('invoiceId', 'amount');

        $data = [
            'merchant_key' => $this->getMerchantKey(),
            'invoice_id' => $this->getInvoiceId(),
            'app_id' => $this->getAppKey(),
            'app_secret' => $this->getAppSecret(),
            'amount' => $this->getAmount(),
        ];

        if ($this->getRefundWebHookKey()) {
            $data['refund_web_hook_key'] = $this->getRefundWebHookKey();
        }

        return $data;
    }

    protected function getEndpoint()
    {
        return $this->getBaseUrl().'/api/refund';
    }

    protected function getResponseClass()
    {
        return RefundResponse::class;
    }
}
