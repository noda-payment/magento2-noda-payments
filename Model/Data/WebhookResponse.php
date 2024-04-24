<?php

declare(strict_types=1);

namespace Noda\Payments\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Magento\Framework\Api\ExtensibleDataInterface;

class WebhookResponse extends AbstractExtensibleObject implements ExtensibleDataInterface
{
    public const KEY_WEBHOOK_STATUS = 'noda_webhook_status';

    /**
     * Get Status
     *
     * @return mixed|null
     */
    public function getStatus()
    {
        return $this->_get(self::KEY_WEBHOOK_STATUS);
    }

    /**
     * Set Status
     *
     * @param mixed|null $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::KEY_WEBHOOK_STATUS, $status);
    }
}
