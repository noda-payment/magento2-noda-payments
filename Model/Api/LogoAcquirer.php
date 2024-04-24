<?php

namespace Noda\Payments\Model\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Exception;
use Noda\Payments\Api\Data\LogoInformationInterface;
use Noda\Payments\Api\LogoAcquirerInterface;
use Noda\Payments\Model\Data\LogoInformationFactory;
use Noda\Payments\Model\Noda\Api\NodaApi;

class LogoAcquirer implements LogoAcquirerInterface
{
    /**
     * @param LogoInformationFactory $logoFactory
     * @param NodaApi $nodaApi
     */
    public function __construct(
        protected readonly LogoInformationFactory $logoFactory,
        protected readonly NodaApi $nodaApi
    ) {
    }

    /**
     * Get Logo Url
     *
     * @return LogoInformationInterface
     * @throws Exception|NoSuchEntityException
     */
    public function getLogoUrl()
    {
        $logo = $this->nodaApi->getLogoUrl();

        /** @var LogoInformationInterface $logoInformation */
        $logoInformation = $this->logoFactory->create();
        $logoInformation->setUrl($logo);

        return $logoInformation;
    }
}
