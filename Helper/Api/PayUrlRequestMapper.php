<?php

declare(strict_types=1);

namespace Noda\Payments\Helper\Api;

use Magento\Framework\Phrase;
use Magento\Sales\Model\OrderFactory;
use Noda\Payments\Api\Data\PayUrlRequestInterface;
use Noda\Payments\Model\Data\PayUrlRequestFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Webapi\Exception;

class PayUrlRequestMapper
{
    /**
     * @param PayUrlRequestFactory $payUrlRequestModelFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderFactory $orderFactory
     */
    public function __construct(
        protected readonly PayUrlRequestFactory $payUrlRequestModelFactory,
        protected readonly OrderRepositoryInterface $orderRepository,
        protected readonly OrderFactory $orderFactory
    ) {
    }

    /**
     * Map Request
     *
     * @param array $payUrlRequest
     * @return PayUrlRequestInterface
     * @throws Exception
     */
    public function mapRequest(array $payUrlRequest)
    {
        /** @var PayUrlRequestInterface $payUrlRequestObject */
        $payUrlRequestObject = $this->payUrlRequestModelFactory->create();

        if (isset($payUrlRequest['payment_id'])) {
            $payUrlRequestObject->setPaymentId($payUrlRequest['payment_id']);
            $payUrlRequestObject->setDescription("Pay for order #" . $payUrlRequest['payment_id']);

            $order = $this->orderFactory->create()->loadByIncrementId((int) $payUrlRequest['payment_id']);

            if (empty($order->getCustomerEmail())) {
                throw new Exception(
                    new Phrase('Failed to load order #' . $payUrlRequest['payment_id'])
                );
            }

            $payUrlRequestObject->setCurrency($order->getOrderCurrencyCode());
            $payUrlRequestObject->setCustomerId($order->getCustomerEmail());
            $this->hashCustomerId($payUrlRequestObject);
            $payUrlRequestObject->setAmount($order->getBaseGrandTotal());
        }

        return $payUrlRequestObject;
    }

    /**
     * Hash Customer id
     *
     * @param PayUrlRequestInterface $payUrlRequest
     * @return PayUrlRequestInterface
     */
    public function hashCustomerId(PayUrlRequestInterface $payUrlRequest)
    {
        $customerId = $payUrlRequest->getCustomerId();
        $hashedCustomerId = hash('sha256', $customerId);
        $payUrlRequest->setCustomerId($hashedCustomerId);

        return $payUrlRequest;
    }
}
