<?php

namespace Noda\Payments\Api;

use Noda\Payments\Model\Data\WebhookResponse;

/**
 * Interface WebhookInterface
 *
 * @api
 * @since 100.0.2
 */
interface WebhookInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Get Noda pay button logo url
     *
     * @return string
     */
    public function updatePaymentStatus();
}
