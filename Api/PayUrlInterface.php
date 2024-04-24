<?php

namespace Noda\Payments\Api;

use Noda\Payments\Api\Data\PayUrlResponseInterface;
use Magento\Framework\Api\ExtensibleDataInterface;

interface PayUrlInterface extends ExtensibleDataInterface
{
    /**
     * Get Pay Url
     *
     * @return PayUrlResponseInterface
     */
    public function getPayUrl();
}
