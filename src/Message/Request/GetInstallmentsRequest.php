<?php

namespace Keune\OmnipaySipay\Message\Request;

use Keune\OmnipaySipay\Message\Response\GetInstallmentsResponse;

class GetInstallmentsRequest extends AbstractSipayRequest
{
    public function getCreditCard()
    {
        return $this->getParameter('creditCard');
    }

    public function setCreditCard($creditCard)
    {
        $this->setParameter('creditCard', $creditCard);
    }

    public function getCommissionBy()
    {
        return $this->getParameter('commissionBy');
    }

    public function setCommissionBy($commissionBy)
    {
        $this->setParameter('commissionBy', $commissionBy);
    }

    public function getIsRecurring()
    {
        return $this->getParameter('isRecurring');
    }

    public function setIsRecurring($isRecurring)
    {
        $this->setParameter('isRecurring', $isRecurring);
    }

    public function getIs2d()
    {
        return $this->getParameter('is2d');
    }

    public function setIs2d($is2d)
    {
        $this->setParameter('is2d', $is2d);
    }

    public function getData()
    {
        $this->validate('creditCard', 'amount', 'currency');

        $data = [
            'merchant_key' => $this->getParameter('merchantKey'),
            'currency_code' => $this->getCurrency(),
        ];

        if ($this->getCreditCard()) {
            $data['credit_card'] = $this->getCreditCard();
        }

        if ($this->getAmount()) {
            $data['amount'] = $this->getAmount();
        }

        if ($this->getCommissionBy()) {
            $data['commission_by'] = $this->getCommissionBy();
        }

        if ($this->getIsRecurring()) {
            $data['is_recurring'] = $this->getIsRecurring();
        }

        if ($this->getIs2d()) {
            $data['is_2d'] = $this->getIs2d();
        }

        return $data;
    }

    protected function getEndpoint()
    {
        return $this->getBaseUrl().'/api/getpos';
    }

    protected function getResponseClass()
    {
        return GetInstallmentsResponse::class;
    }
}
