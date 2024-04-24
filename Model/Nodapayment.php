<?php

declare(strict_types=1);

namespace Noda\Payments\Model;

use Magento\Directory\Helper\Data as DirectoryHelper;
use Throwable;
use Magento\Store\Model\StoreManagerInterface;

class Nodapayment extends \Magento\Payment\Model\Method\AbstractMethod
{
    public const PAYMENT_METHOD_NODAPAYMENT_CODE = 'nodapayment';
    public const SUPPORTED_CURRENCIES = [
        'pln',
        'eur',
        'gbp',
        'cad',
        'brl',
        'pln',
        'bgn',
        'ron',
    ];

    /**
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_NODAPAYMENT_CODE;

    /**
     * @var string
     */
    protected $_formBlockType = \Noda\Payments\Block\Form\Nodapayment::class;

    /**
     * @var string
     */
    protected $_infoBlockType = \Noda\Payments\Block\Info\Nodapayment::class;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\Payment\Helper\Data $paymentData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Payment\Model\Method\Logger $logger
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     * @param DirectoryHelper|null $directory
     */
    public function __construct(
        protected readonly StoreManagerInterface $storeManager,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [],
        DirectoryHelper $directory = null
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            $data,
            $directory
        );
    }

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

    /**
     * Check Is Available
     *
     * @param \Magento\Quote\Api\Data\CartInterface|null $quote
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        if (!parent::isAvailable($quote)) {
            return false;
        }

        try {
            return in_array(
                strtolower($this->storeManager->getStore()->getCurrentCurrency()->getCode()),
                self::SUPPORTED_CURRENCIES,
                true
            );
        } catch (Throwable $e) {
            return true; // if currency data is not set for some reason - allow payment method by default.
        }
    }
}
