<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Common\Helper;
use Keune\OmnipaySipay\Message\Response\ThreeDSecureInitResponse;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;

class ThreeDSecureInitRequest extends AbstractSipayRequest
{
    public function generateHashKey($total, $installment, $currency_code, $merchant_key, $invoice_id): string
    {
        $data = $total.'|'.$installment.'|'.$currency_code.'|'.$merchant_key.'|'.$invoice_id;

        return Helper::generateHash($data, $this->getAppSecret());
    }

    public function setInstallmentNumber(int $installmentNumber)
    {
        $this->setParameter('installmentNumber', $installmentNumber);
    }

    public function getInstallmentNumber(): int
    {
        return $this->getParameter('installmentNumber') ?: 1;
    }

    public function getData()
    {
        $this->validate('amount', 'card', 'transactionId', 'items', 'returnUrl', 'cancelUrl', 'currency');

        $card = $this->getCard();
        $card->validate();
        if (!$card->getName()) {
            throw new InvalidCreditCardException('Card holder name is required');
        }
        if (!$card->getCvv()) {
            throw new InvalidCreditCardException('CVV is required');
        }

        $itemData = [];
        $items = $this->getItems();
        foreach ($items as $item) {
            $item->validate();
            if (!$item->getPrice()) {
                throw new InvalidRequestException('Item price parameter is required');
            }
            $itemDatum = [
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'quantity' => $item->getQuantity(),
            ];
            if ($item->getDescription()) {
                $itemDatum['description'] = $item->getDescription();
            }
            $itemData[] = $itemDatum;
        }

        $month = substr('0'.$card->getExpiryMonth(), -2);

        $hashKey = $this->generateHashKey(
            $this->getAmount(),
            $this->getInstallmentNumber(),
            $this->getCurrency(),
            $this->getMerchantKey(),
            $this->getTransactionId()
        );

        $formData = [
            'merchant_key' => $this->getMerchantKey(),
            'cc_holder_name' => $card->getName() ?? '',
            'cc_no' => $card->getNumber(),
            'expiry_month' => $month,
            'expiry_year' => $card->getExpiryYear(),
            'cvv' => $card->getCvv(),
            'currency_code' => $this->getCurrency(),
            'installments_number' => $this->getInstallmentNumber(),
            'invoice_id' => $this->getTransactionId(),
            'invoice_description' => $this->getTransactionId(),
            'name' => $card->getBillingFirstName() ?: '',
            'surname' => $card->getBillingLastName() ?: '',
            'total' => $this->getAmount(),
            'items' => json_encode($itemData),
            'return_url' => $this->getReturnUrl(),
            'cancel_url' => $this->getCancelUrl(),
            'hash_key' => $hashKey,
            'payment_completed_by' => 'merchant',
        ];

        if ($this->getClientIp()) {
            $formData['ip'] = $this->getClientIp();
        }

        return [
            'redirectUrl' => $this->getEndpoint(),
            'form' => $formData,
        ];
    }

    protected function getEndpoint()
    {
        return $this->getBaseUrl().'/api/paySmart3D';
    }

    protected function getResponseClass()
    {
        return ThreeDSecureInitResponse::class;
    }

    public function sendData($data)
    {
        // no request will be made to sipay. the initial step for 3d is sending the form
        $class = $this->getResponseClass();

        return $this->response = new $class($this, $data);
    }
}
