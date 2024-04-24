<?php

declare(strict_types=1);

namespace Noda\Payments\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Noda\Payments\Api\Data\PayUrlResponseInterface;

class PayUrlResponse extends AbstractExtensibleObject implements PayUrlResponseInterface
{
    public const KEY_PAY_URL = 'noda_pay_url';

    /**
     * Get Pay Url
     *
     * @return string
     */
    public function getPayUrl(): string
    {
        return $this->_get(self::KEY_PAY_URL);
    }

    /**
     * Set Pay Url
     *
     * @param string $payUrl
     * @return PayUrlResponse
     */
    public function setPayUrl($payUrl)
    {
        return $this->setData(self::KEY_PAY_URL, $payUrl);
    }
}
