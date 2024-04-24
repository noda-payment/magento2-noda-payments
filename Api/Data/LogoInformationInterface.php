<?php

namespace Noda\Payments\Api\Data;

use Noda\Payments\Model\Data\LogoInformation;
use Magento\Framework\Api\ExtensibleDataInterface;

interface LogoInformationInterface extends ExtensibleDataInterface
{
    /**
     * Get Url
     *
     * @return mixed|null
     */
    public function getUrl();

    /**
     * Set Url
     *
     * @param mixed|null $url
     * @return $this
     */
    public function setUrl($url);
}
