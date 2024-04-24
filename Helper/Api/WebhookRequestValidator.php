<?php

declare(strict_types=1);

namespace Noda\Payments\Helper\Api;

use Magento\Sales\Model\OrderFactory;
use Noda\Payments\Api\Data\WebhookRequestInterface;
use Noda\Payments\Model\Config;
use Noda\Payments\Model\Nodapayment;

class WebhookRequestValidator
{
    public const SUPPORTED_CURRENCIES = Nodapayment::SUPPORTED_CURRENCIES;
    public const OBLIGATORY_FIELDS = ['status', 'paymentId', 'currency', 'merchantPaymentId', 'amount', 'signature'];
    public const VALID_NODA_PAYMENT_STATUSES = ['done', 'failed', 'processing'];

    /**
     * @param OrderFactory $orderFactory
     * @param Config $scopeConfig
     */
    public function __construct(
        protected readonly OrderFactory $orderFactory,
        protected readonly Config $scopeConfig
    ) {
    }

    /**
     * Validate Request
     *
     * @param WebhookRequestInterface $webhookRequestInterface
     * @return string[]
     */
    public function validateRequest(WebhookRequestInterface $webhookRequestInterface)
    {
        $validationErrors = [];

        foreach (self::OBLIGATORY_FIELDS as $field) {
            $methodName = 'get' . ucfirst($field);
            if ($webhookRequestInterface->{$methodName}() === null) {
                $validationErrors[] = '\'' . ucfirst($field)  . '\' field is missing in request';
            }
        }

        if (!is_numeric($webhookRequestInterface->getAmount())) {
            $validationErrors[] = '\'Amount\' field is not a valid amount value';
        }

        if ((float) $webhookRequestInterface->getAmount() <= 0) {
            $validationErrors[] = '\'Amount\' of payment should be a positive numeric value';
        }

        if (!in_array(trim(strtolower($webhookRequestInterface->getStatus())), self::VALID_NODA_PAYMENT_STATUSES)) {
            $validationErrors[] = '\'' . $webhookRequestInterface->getStatus()
                . '\' payment status is not a valid status (accepted values are: '
                . implode(', ', self::VALID_NODA_PAYMENT_STATUSES);
        }

        if (!in_array(trim(strtolower($webhookRequestInterface->getCurrency())), Nodapayment::SUPPORTED_CURRENCIES)) {
            $validationErrors[] = '\'Currency\' is not among the list of supported currencies: '
                . implode(', ', self::SUPPORTED_CURRENCIES);
        }

        if ($this->signatureIsInvalid(
            $webhookRequestInterface->getSignature(),
            $webhookRequestInterface->getPaymentId(),
            $webhookRequestInterface->getStatus()
        )) {
            $validationErrors[] = 'Invalid signature';
        }

        return $validationErrors;
    }

    /**
     * Get Validate Order
     *
     * @param WebhookRequestInterface $webhookRequestInterface
     * @param array $validationErrors
     * @return \Magento\Sales\Api\Data\OrderInterface|null
     */
    public function getValidOrder(WebhookRequestInterface $webhookRequestInterface, &$validationErrors)
    {
        $orderId = $webhookRequestInterface->getPaymentId();
        $order = $this->orderFactory->create()->loadByIncrementId($orderId);

        if ($order === null || $order->getCustomerId() === null) {
            $validationErrors[] = 'Oreder #' . $orderId . ' was not found';

            return null;
        }

        if (!in_array(strtolower($order->getOrderCurrency()->getCurrencyCode()), self::SUPPORTED_CURRENCIES)) {
            $validationErrors[] = 'Invalid order currency';
        }

        return $order;
    }

    /**
     * Signature Invalid id
     *
     * @param string $requestSignature
     * @param string $orderId
     * @param string $requestStatus
     * @return bool
     */
    private function signatureIsInvalid($requestSignature, $orderId, $requestStatus): bool
    {
        $expectedSignature = hash('sha256', $orderId . $requestStatus . $this->scopeConfig->getSignature());

        return $requestSignature !== $expectedSignature;
    }
}
