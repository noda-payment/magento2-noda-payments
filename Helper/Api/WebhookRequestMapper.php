<?php

declare(strict_types=1);

namespace Noda\Payments\Helper\Api;

use Noda\Payments\Api\Data\WebhookRequestInterface;
use Noda\Payments\Model\Data\WebhookRequestFactory;

class WebhookRequestMapper
{
    public const REQUEST_KEY_PAYMENT_ID = 'PaymentId';
    public const REQUEST_KEY_STATUS = 'Status';
    public const REQUEST_KEY_SIGNATURE = 'Signature';
    public const REQUEST_KEY_MERCHANT_PAYMENT_ID = 'MerchantPaymentId';
    public const REQUEST_KEY_AMOUNT = 'Amount';
    public const REQUEST_KEY_CURRENCY = 'Currency';
    // for now we do not use this field though may add support for it later
    public const REQUEST_KEY_REFERENCE = 'Reference';
    // for now we do not use this field though may add support for it later
    public const REQUEST_KEY_REMITTER = 'Remitter';

    /**
     * @param WebhookRequestFactory $webhookRequestModelFactory
     */
    public function __construct(
        protected readonly WebhookRequestFactory $webhookRequestModelFactory
    ) {
    }

    /**
     * Request Mapper
     *
     * @param array $webhookRequest
     * @return WebhookRequestInterface
     */
    public function mapRequest(array $webhookRequest): WebhookRequestInterface
    {
        /** @var WebhookRequestInterface $webhookRequestObject */
        $webhookRequestObject = $this->webhookRequestModelFactory->create();

        if (isset($webhookRequest[self::REQUEST_KEY_PAYMENT_ID])) {
            $webhookRequestObject->setPaymentId($webhookRequest[self::REQUEST_KEY_PAYMENT_ID]);
        }

        if (isset($webhookRequest[self::REQUEST_KEY_STATUS])) {
            $webhookRequestObject->setStatus($webhookRequest[self::REQUEST_KEY_STATUS]);
        }

        if (isset($webhookRequest[self::REQUEST_KEY_SIGNATURE])) {
            $webhookRequestObject->setSignature($webhookRequest[self::REQUEST_KEY_SIGNATURE]);
        }

        if (isset($webhookRequest[self::REQUEST_KEY_MERCHANT_PAYMENT_ID])) {
            $webhookRequestObject->setMerchantPaymentId($webhookRequest[self::REQUEST_KEY_MERCHANT_PAYMENT_ID]);
        }

        if (isset($webhookRequest[self::REQUEST_KEY_AMOUNT])) {
            $webhookRequestObject->setAmount($webhookRequest[self::REQUEST_KEY_AMOUNT]);
        }

        if (isset($webhookRequest[self::REQUEST_KEY_CURRENCY])) {
            $webhookRequestObject->setCurrency($webhookRequest[self::REQUEST_KEY_CURRENCY]);
        }

        return $webhookRequestObject;
    }
}
