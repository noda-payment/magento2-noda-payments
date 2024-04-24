<?php

namespace Noda\Payments\Model\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Noda\Payments\Api\Data\PayUrlResponseInterface;
use Noda\Payments\Api\PayUrlInterface;
use Noda\Payments\Helper\Api\PayUrlRequestMapper;
use Noda\Payments\Model\Data\PayUrlResponse;
use Noda\Payments\Model\Data\PayUrlResponseFactory;
use Noda\Payments\Model\Noda\Api\NodaApi;

class PayUrl implements PayUrlInterface
{
    /**
     * @param NodaApi $nodaApi
     * @param PayUrlRequestMapper $payUrlRequestMapper
     * @param Request $request
     * @param PayUrlResponseFactory $payUrlResponseFactory
     */
    public function __construct(
        protected readonly NodaApi $nodaApi,
        protected readonly PayUrlRequestMapper $payUrlRequestMapper,
        protected readonly Request $request,
        protected readonly PayUrlResponseFactory $payUrlResponseFactory
    ) {
    }

    /**
     * Get Pay Url
     *
     * @return PayUrlResponseInterface
     * @throws Exception|NoSuchEntityException
     */
    public function getPayUrl()
    {
        $payUrlRequestBody = $this->request->getBodyParams();

        $payUrlDto = $this->payUrlRequestMapper->mapRequest($payUrlRequestBody);

        $nodaPayUrl = $this->nodaApi->createPaymentUrl($payUrlDto);

        /** @var PayUrlResponse $payUrlResponse */
        $nodaPayUrlResponse = $this->payUrlResponseFactory->create();

        $nodaPayUrlResponse->setPayUrl($nodaPayUrl);

        return $nodaPayUrlResponse;
    }
}
