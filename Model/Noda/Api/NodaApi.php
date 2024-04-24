<?php

declare(strict_types=1);

namespace Noda\Payments\Model\Noda\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Store\Model\StoreManagerInterface;
use Noda\Payments\Api\Data\PayUrlRequestInterface;
use Noda\Payments\Model\Api\Webhook;
use Noda\Payments\Model\Config;

class NodaApi
{
    public const NODA_LOGO_ENDPOINT = '/api/payments/logo';
    public const NODA_PAY_URL_ENDPOINT = '/api/payments';

    /**
     * @param Config $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Client $client
     * @param ClientFactory $clientFactory
     * @param Response $response
     * @param ResponseFactory $responseFactory
     * @param Request $httpRequest
     * @param SerializerInterface $serializer
     */
    public function __construct(
        protected readonly Config $scopeConfig,
        protected readonly StoreManagerInterface $storeManager,
        protected readonly Client $client,
        protected readonly ClientFactory $clientFactory,
        protected readonly Response $response,
        protected readonly ResponseFactory $responseFactory,
        protected readonly Request $httpRequest,
        protected readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * Get Logo Url
     *
     * @return string
     * @throws Exception
     * @throws NoSuchEntityException
     */
    public function getLogoUrl(): string
    {
        $currencyCode = $this->storeManager->getStore()->getBaseCurrencyCode();

        $result = $this->doRequest(
            self::NODA_LOGO_ENDPOINT,
            ['currency' => $currencyCode]
        );

        return $result['url'];
    }

    /**
     * Create Payment Url
     *
     * @param PayUrlRequestInterface $payUrlRequest
     * @return mixed
     * @throws Exception
     * @throws NoSuchEntityException
     */
    public function createPaymentUrl(PayUrlRequestInterface $payUrlRequest)
    {
        $postData = [
            'amount' => $payUrlRequest->getAmount(),
            'currency' => $payUrlRequest->getCurrency(),
            'customerId' => $payUrlRequest->getCustomerId(),
            'description' => $payUrlRequest->getDescription(),
            'shopId' => $this->scopeConfig->getShopId(),
            'paymentId' => $payUrlRequest->getPaymentId(),
            'returnUrl' => $this->storeManager->getStore()->getBaseUrl(),
            'webhookUrl' => $this->storeManager->getStore()->getBaseUrl() . '/rest/' .Webhook::WEBHOOK_URL,
        ];

        $result = $this->doRequest(
            self::NODA_PAY_URL_ENDPOINT,
            $postData
        );

        return $result['url'];
    }

    /**
     * Do Request
     *
     * @param string $uriEndpoint
     * @param array $data
     * @param string $requestMethod
     * @return array
     * @throws Exception
     */
    private function doRequest(
        string $uriEndpoint,
        array $data = [],
        string $requestMethod = Request::HTTP_METHOD_POST
    ) {
        /** @var Client $client */
        $client = $this->clientFactory->create(
            [
                'config' => [
                    'base_uri' => $this->scopeConfig->getApiUrl()
                ]
            ]
        );

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                [
                    'headers' => [
                        'Accept' => 'application/json, text/json, text/plain',
                        'Content-Type' => 'application/*+json',
                        'x-api-key' => $this->scopeConfig->getApiKey()
                    ],
                    'json' => $data
                ]
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        if ($response->getStatusCode() !== 200) {
            throw new Exception(new Phrase($response->getReasonPhrase()));
        }

        return $this->parseResult($response);
    }

    /**
     * Unserialize Result
     *
     * @param Response $result
     * @return array
     */
    private function parseResult(Response $result): array
    {
        return $this->serializer->unserialize($result->getBody()->getContents());
    }
}
