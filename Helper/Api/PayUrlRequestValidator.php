<?php

declare(strict_types=1);

namespace Noda\Payments\Helper\Api;

use Magento\Framework\Api\AbstractExtensibleObject;
use Magento\Sales\Model\OrderFactory;
use Noda\Payments\Model\Data\PayUrlRequest;

class PayUrlRequestValidator
{
    public const REQUIRED_FIELDS = [
        'payment_id' => 'paymentId',
    ];

    /**
     * @param OrderFactory $orderFactory
     */
    public function __construct(
        protected readonly OrderFactory $orderFactory
    ) {
    }

    /**
     * Validate Request
     *
     * @param PayUrlRequest $payUrlRequest
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validateRequest(PayUrlRequest $payUrlRequest)
    {
        $validationErrors = [];

        $this->validateRequiredFieldsPresent($payUrlRequest, self::REQUIRED_FIELDS, $validationErrors);

        try {
            $order = $this->orderFactory->create()->loadByIncrementId($payUrlRequest->getPaymentId());

            if (!$order->getEntityId()) {
                $validationErrors[] = 'Order #'. $payUrlRequest->getPaymentId() .' not found';

                return $validationErrors;
            }
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $validationErrors[] = 'Customer not found';
            return $validationErrors;
        }

        return $validationErrors;
    }

    /**
     * Validate Required Fields Present
     *
     * @param AbstractExtensibleObject $requestObject Object of dto or class containing request data
     * @param array $requiredFields
     * @param array $validationErrors
     */
    public function validateRequiredFieldsPresent(
        AbstractExtensibleObject $requestObject,
        array $requiredFields,
        array &$validationErrors
    ) {
        foreach ($requiredFields as $requiredField => $propertyName) {
            $getter = 'get' . ucfirst($propertyName);
            if (!method_exists($requestObject, $getter) || $requestObject->{$getter}() === null) {
                $validationErrors[] = 'Required field \''
                    . $requiredField
                    . '\' is missing in '
                    . get_class($requestObject);
            }
        }
    }
}
