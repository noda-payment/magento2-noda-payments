<?php

namespace Noda\Payments\Api\Data;

/**
 * Webhook Request object interface
 * @api
 * @since 100.0.2
 *
 * @see https://docs.noda.live/docs/noda-pay-api/22989088c5b85-creating-a-payment
 */
interface WebhookRequestInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    public const PAYMENT_ID = 'paymentId'; //Payment identifier in Noda system
    public const STATUS = 'status'; //Done, Failed or Processing
    // Example: "6ec13bda02080a4006223c1ba9d8fa97e2de0a1ca782d95d63f4b69789117cc6" // Signature
    public const SIGNATURE = 'signature';
    public const MERCHANT_PAYMENT_ID = 'merchantPaymentId';//Merchant payment identificator, ie. shopId from Noda config
    public const AMOUNT = 'amount'; // Amount for transaction // Example: 1.00
    public const CURRENCY = 'currency'; // Currency code. Example: EUR, GBP or PLN
    public const REFERENCE = 'reference'; // Payment reference in Noda // not currently used
    public const REMITTER = 'remitter'; // Remitter information// Not currently used
    /**#@-*/

    /**
     * Get payment identifier in Noda system
     *
     * @return string
     */
    public function getPaymentId();

    /**
     * Get Status of payment
     *
     * Possible values are: Done, Failed or Processing
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get Signature of request
     *
     * @return string
     */
    public function getSignature();

    /**
     * Get merchant payment identifier
     *
     * @return string
     */
    public function getMerchantPaymentId();

    /**
     * Get payment amount
     *
     * @return string
     */
    public function getAmount();

    /**
     * Get payment currency code
     *
     * @return string
     */
    public function getCurrency();

    /**
     * Get payment reference in Noda system
     *
     * @return string|null
     */
    public function getReference();

    /**
     * Get remitter information
     *
     * @return string|null
     */
    public function getRemitter();

    /**
     * Set payment id
     *
     * @param string $paymentId
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setPaymentId($paymentId);

    /**
     * Set status
     *
     * @param string $status
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setStatus($status);

    /**
     * Set signature
     *
     * @param string $signature
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setSignature($signature);

    /**
     * Set merchant payment identifier
     *
     * @param string $merchantPaymentId
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setMerchantPaymentId($merchantPaymentId);

    /**
     *  Set amount
     *
     * @param string $amount
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setAmount($amount);

    /**
     * Set currency code
     *
     * @param string $currency
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setCurrency($currency);

    /**
     * Set reference
     *
     * @param string|null $reference
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setReference($reference);

    /**
     * Sst Remitter
     *
     * @param string|null $remitter
     * @return \Noda\Payments\Api\Data\WebhookRequestInterface
     */
    public function setRemitter($remitter);
}
