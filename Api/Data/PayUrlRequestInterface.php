<?php

namespace Noda\Payments\Api\Data;

interface PayUrlRequestInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    public const KEY_AMOUNT = 'amount';
    public const KEY_CURRENCY = 'currency';
    public const KEY_CUSTOMER_ID = 'customer_id';
    public const KEY_DESCRIPTION = 'description';
    public const KEY_PAYMENT_ID = 'payment_id';

    /**
     * Get amount of payment
     *
     * @return string
     */
    public function getAmount();

    /**
     * Get currency code
     *
     * @return string
     */
    public function getCurrency();

    /**
     * Get id of customer
     *
     * @return string
     */
    public function getCustomerId();

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get payment id
     *
     * @return string
     */
    public function getPaymentId();

    /**
     * Set amount
     *
     * @param string $amount
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setAmount($amount);

    /**
     * Set currency
     *
     * @param string $currency
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setCurrency($currency);

    /**
     * Set customer id
     *
     * @param string $customerId
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setCustomerId($customerId);

    /**
     * Set description
     *
     * @param string|null $description
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setDescription($description);

    /**
     * Set payment id
     *
     * @param string $paymentId
     * @return \Noda\Payments\Api\Data\PayUrlRequestInterface
     */
    public function setPaymentId($paymentId);
}
