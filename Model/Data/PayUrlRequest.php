<?php

declare(strict_types=1);

namespace Noda\Payments\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Noda\Payments\Api\Data\PayUrlRequestInterface;

class PayUrlRequest extends AbstractExtensibleObject implements PayUrlRequestInterface
{
    /**
     * Get amount of payment
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->_get(PayUrlRequestInterface::KEY_AMOUNT);
    }

    /**
     * Get currency code
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->_get(PayUrlRequestInterface::KEY_CURRENCY);
    }

    /**
     * Get id of customer
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->_get(PayUrlRequestInterface::KEY_CUSTOMER_ID);
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->_get(PayUrlRequestInterface::KEY_DESCRIPTION);
    }

    /**
     * Get payment id
     *
     * @return string
     */
    public function getPaymentId()
    {
        return $this->_get(PayUrlRequestInterface::KEY_PAYMENT_ID);
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setAmount($amount)
    {
        return $this->setData(PayUrlRequestInterface::KEY_AMOUNT, $amount);
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setCurrency($currency)
    {
        return $this->setData(PayUrlRequestInterface::KEY_CURRENCY, $currency);
    }

    /**
     * Set customer id
     *
     * @param string $customerId
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(PayUrlRequestInterface::KEY_CUSTOMER_ID, $customerId);
    }

    /**
     * Set description
     *
     * @param string|null $description
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setDescription($description)
    {
        return $this->setData(PayUrlRequestInterface::KEY_DESCRIPTION, $description);
    }

    /**
     * Set payment id
     *
     * @param string $paymentId
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setPaymentId($paymentId)
    {
        return $this->setData(PayUrlRequestInterface::KEY_PAYMENT_ID, $paymentId);
    }
}
