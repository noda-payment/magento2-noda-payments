<?php

declare(strict_types=1);

namespace Noda\Payments\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Noda\Payments\Api\Data\WebhookRequestInterface;

class WebhookRequest extends AbstractExtensibleObject implements WebhookRequestInterface
{
    /**
     * Get payment identifier in Noda system
     *
     * @return string
     */
    public function getPaymentId()
    {
        return $this->_get(WebhookRequestInterface::PAYMENT_ID);
    }

    /**
     * Get Status of payment
     *
     * Possible values are: Done, Failed or Processing
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_get(WebhookRequestInterface::STATUS);
    }

    /**
     * Get Signature of request
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->_get(WebhookRequestInterface::SIGNATURE);
    }

    /**
     * Get merchant payment identifier
     *
     * @return string
     */
    public function getMerchantPaymentId()
    {
        return $this->_get(WebhookRequestInterface::MERCHANT_PAYMENT_ID);
    }

    /**
     * Get payment amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->_get(WebhookRequestInterface::AMOUNT);
    }

    /**
     * Get payment currency code
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->_get(WebhookRequestInterface::CURRENCY);
    }

    /**
     * Get payment reference in Noda system
     *
     * @return string|null
     */
    public function getReference()
    {
        return $this->_get(WebhookRequestInterface::REFERENCE);
    }

    /**
     * Get remitter information
     *
     * @return string|null
     */
    public function getRemitter()
    {
        return $this->_get(WebhookRequestInterface::REMITTER);
    }

    /**
     * Set payment id
     *
     * @param string $paymentId
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setPaymentId($paymentId)
    {
        return $this->setData(self::PAYMENT_ID, $paymentId);
    }

    /**
     * Set status
     *
     * @param string $status
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set signature
     *
     * @param string $signature
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setSignature($signature)
    {
        return $this->setData(self::SIGNATURE, $signature);
    }

    /**
     * Set merchant payment identifier
     *
     * @param string $merchantPaymentId
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setMerchantPaymentId($merchantPaymentId)
    {
        return $this->setData(self::MERCHANT_PAYMENT_ID, $merchantPaymentId);
    }

    /**
     *  Set amount
     *
     * @param string $amount
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setAmount($amount)
    {
        return $this->setData(self::AMOUNT, $amount);
    }

    /**
     * Set currency code
     *
     * @param string $currency
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setCurrency($currency)
    {
        return $this->setData(self::CURRENCY, $currency);
    }

    /**
     * Set reference
     *
     * @param string|null $reference
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setReference($reference)
    {
        return $this->setData(self::REFERENCE, $reference);
    }

    /**
     * Set Remitter
     *
     * @param string|null $remitter
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setRemitter($remitter)
    {
        return $this->setData(self::REMITTER, $remitter);
    }
}
