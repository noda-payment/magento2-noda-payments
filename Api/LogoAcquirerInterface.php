<?php


namespace Noda\Payments\Api;

use Noda\Payments\Api\Data\LogoInformationInterface;

interface LogoAcquirerInterface
{
    /**
     * Get Noda pay button logo url
     *
     * @return LogoInformationInterface
     */
    public function getLogoUrl();
}
