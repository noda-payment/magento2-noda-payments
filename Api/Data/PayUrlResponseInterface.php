<?php

namespace Noda\Payments\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface PayUrlResponseInterface extends ExtensibleDataInterface
{
    /**
     * Get Pay Url
     *
     * @return string
     */
    public function getPayUrl(): string;

    /**
     * Sey Pay Url
     *
     * @param string|null $payUrl
     * @return mixed
     */
    public function setPayUrl($payUrl);
}
