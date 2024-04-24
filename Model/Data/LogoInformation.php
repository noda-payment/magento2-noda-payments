<?php

declare(strict_types=1);

namespace Noda\Payments\Model\Data;

use Noda\Payments\Api\Data\LogoInformationInterface;

class LogoInformation extends \Magento\Framework\Api\AbstractExtensibleObject implements LogoInformationInterface
{
    public const KEY_LOGO_URL = 'noda_logo';

    /**
     * Get Url
     *
     * @return mixed|null
     */
    public function getUrl()
    {
        return $this->_get(self::KEY_LOGO_URL);
    }

    /**
     * Set Url
     *
     * @param mixed|null $url
     * @return $this
     */
    public function setUrl($url)
    {
        return $this->setData(self::KEY_LOGO_URL, $url);
    }
}
