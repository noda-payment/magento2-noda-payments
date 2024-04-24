<?php

namespace Noda\Payments\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\MutableScopeConfig;
use Magento\Payment\Gateway\ConfigInterface;
use Magento\Config\Model\Config\Backend\Encrypted;

class Config implements ConfigInterface
{
    public const METHOD_NODAPAY = 'nodapayment';

    public const NODA_API_URL_TEST = 'https://api.stage.noda.live';
    public const NODA_API_URL_LIVE = 'https://api.noda.live';

    public const API_CONFIG_DEV_API_KEY = '24d0034-5a83-47d5-afa0-cca47298c516';
    public const API_CONFIG_DEV_SIGNATURE = '028b9b98-f250-492c-a63a-dfd7c112cc0a';
    public const API_CONFIG_DEV_SHOP_ID = 'd0c3ccd9-162c-497e-808b-e769aea89c58';

    /**
     * Current payment method code
     *
     * @var string
     */
    private $_methodCode = 'nodapay';

    /**
     * Current store id
     *
     * @var int
     */
    private $_storeId;

    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var string
     */
    private $pathPattern;

    /**
     * @param MutableScopeConfig $_scopeConfig
     * @param Encrypted $encrypted
     */
    public function __construct(
        protected readonly MutableScopeConfig $_scopeConfig,
        protected readonly Encrypted $encrypted,
    ) {
    }

    /**
     * @var MethodInterface
     */
    protected $methodInstance;

    /**
     * Sets method instance used for retrieving method specific data
     *
     * @param MethodInterface $method
     * @return $this
     */
    public function setMethodInstance($method)
    {
        $this->methodInstance = $method;
        return $this;
    }

    /**
     * Method code setter
     *
     * @param string|MethodInterface $method
     * @return $this
     */
    public function setMethod($method)
    {
        if ($method instanceof MethodInterface) {
            $this->_methodCode = $method->getCode();
        } elseif (is_string($method)) {
            $this->_methodCode = $method;
        }

        return $this;
    }

    /**
     * Store ID setter
     *
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        $this->_storeId = (int)$storeId;

        return $this;
    }

    /**
     * Get Api Key
     *
     * @return string
     */
    public function getApiKey()
    {
        if ($this->getValue('is_test') === '1' && empty($this->getValue('api_key'))) {
            return self::API_CONFIG_DEV_API_KEY;
        }

        return $this->_encrypted->processValue($this->getValue('api_key'));
    }

    /**
     * Get Signrature
     *
     * @return string
     */
    public function getSignature()
    {
        if ($this->getValue('is_test') === '1' && empty($this->getValue('signature'))) {
            return self::API_CONFIG_DEV_SIGNATURE;
        }

        return $this->_encrypted->processValue($this->getValue('signature'));
    }

    /**
     * Get Shop id
     *
     * @return string
     */
    public function getShopId()
    {
        if ($this->getValue('is_test') === '1' && empty($this->getValue('shop_id'))) {
            return self::API_CONFIG_DEV_SHOP_ID;
        }

        return $this->_encrypted->processValue($this->getValue('shop_id'));
    }

    /**
     * Returns payment configuration value
     *
     * @param string $key
     * @param null|int $storeId
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getValue($key, $storeId = null)
    {
        $underscored = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $key));
        $path = $this->_getSpecificConfigPath($underscored);

        if ($path === null) {
            return null;
        }

        return $this->_scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $this->_storeId
        );
    }

    /**
     * Map any supported payment method into a config path by specified field name
     *
     * @param string $fieldName
     * @return string|null
     */
    protected function _getSpecificConfigPath($fieldName)
    {
        return "payment/".self::METHOD_NODAPAY."/" . $fieldName;
    }

    /**
     * Check whether method available for checkout or not
     *
     * @param null|string $methodCode
     *
     * @return bool
     */
    public function isMethodAvailable($methodCode = null)
    {
        $methodCode = $methodCode ?: $this->_methodCode;

        return $this->isMethodActive($methodCode);
    }

    /**
     * Check whether payment is in test mode, where no real payments are processed
     *
     * @return bool
     */
    protected function isTestMode()
    {
        return $this->getValue('is_test') === '1';
    }

    /**
     * Check whether method active in configuration and supported for merchant country or not
     *
     * @param string $method Method code
     * @return bool
     */
    public function isMethodActive($method)
    {
        if ($method !== self::METHOD_NODAPAY) {
            return false;
        }

        return $this->_scopeConfig->isSetFlag(
            'payment/' . self::METHOD_NODAPAY .'/active',
            ScopeInterface::SCOPE_STORE,
            $this->_storeId
        );
    }

    /**
     * The getter function to get the ProductMetadata
     *
     * @return ProductMetadataInterface|mixed
     */
    protected function getProductMetadata()
    {
        if ($this->productMetadata === null) {
            $this->productMetadata = ObjectManager::getInstance()->get(ProductMetadataInterface::class);
        }
        return $this->productMetadata;
    }

    /**
     * Sets path pattern
     *
     * @param string $pathPattern
     * @return void
     */
    public function setPathPattern($pathPattern)
    {
        $this->pathPattern = $pathPattern;
    }

    /**
     * Get Api Url
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->isTestMode() ? self::NODA_API_URL_TEST : self::NODA_API_URL_LIVE;
    }

    /**
     * Set Method Code
     *
     * @param string $methodCode
     * @return void
     */
    public function setMethodCode($methodCode)
    {
        $this->_methodCode = $methodCode;
    }
}
