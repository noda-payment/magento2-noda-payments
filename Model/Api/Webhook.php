<?php

namespace Noda\Payments\Model\Api;

use Magento\Framework\Phrase;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Sales\Api\InvoiceOrderInterface;
use Noda\Payments\Api\WebhookInterface;
use Noda\Payments\Helper\Api\WebhookRequestMapper;
use Noda\Payments\Helper\Api\WebhookRequestValidator;
use Noda\Payments\Model\Data\WebhookResponse;
use Noda\Payments\Model\Data\WebhookResponseFactory;

class Webhook implements WebhookInterface
{
    public const WEBHOOK_URL = '/V1/nodapay/webhook';

    /**
     * @param WebhookResponseFactory $webhookResponseFactory
     * @param Request $request
     * @param WebhookRequestMapper $webhookRequestMapper
     * @param WebhookRequestValidator $webhookRequestValidator
     * @param InvoiceOrderInterface $invoiceOrder
     */
    public function __construct(
        protected readonly WebhookResponseFactory $webhookResponseFactory,
        protected readonly Request $request,
        protected readonly WebhookRequestMapper $webhookRequestMapper,
        protected readonly WebhookRequestValidator $webhookRequestValidator,
        protected readonly InvoiceOrderInterface $invoiceOrder
    ) {
    }

    /**
     * Update Payment Status
     *
     * @return WebhookResponse
     * @throws Exception
     */
    public function updatePaymentStatus()
    {
        $webhookRequestBody = $this->request->getBodyParams();
        $webhookRequest = $this->webhookRequestMapper->mapRequest($webhookRequestBody);

        $validationErrors = $this->webhookRequestValidator->validateRequest($webhookRequest);

        if (!empty($validationErrors)) {
            throw new Exception(new Phrase(implode('; ', $validationErrors)));
        }

        $orderInSystem = $this->webhookRequestValidator->getValidOrder($webhookRequest, $validationErrors);

        if (!empty($validationErrors)) {
            throw new Exception(new Phrase(implode('; ', $validationErrors)));
        }

        if ($orderInSystem) {
            if ($webhookRequest->getStatus() === 'Failed') {
                $orderInSystem->setStatus('canceled');
                $orderInSystem->save();
            } elseif ($webhookRequest->getStatus() === 'Done') {
                $orderInSystem->setStatus('payment_review'); // check valid statuses in magento;
                $orderInSystem->save();
                $this->invoiceOrder->execute($orderInSystem->getEntityId());
            } elseif ($webhookRequest->getStatus() === 'Processing') {
                $orderInSystem->setStatus('pending_payment');
                $orderInSystem->save();
            }
        }

        $webhookResponse = $this->webhookResponseFactory->create();
        $webhookResponse->setStatus('updated');

        return $webhookResponse;
    }
}
