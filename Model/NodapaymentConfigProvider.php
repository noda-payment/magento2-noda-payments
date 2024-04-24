<?php

namespace Noda\Payments\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Escaper;
use Magento\Payment\Helper\Data as PaymentHelper;

class NodapaymentConfigProvider implements ConfigProviderInterface
{
    /**
     * @var string[]
     */
    protected $methodCode = Nodapayment::PAYMENT_METHOD_NODAPAYMENT_CODE;

    /**
     * @var Nodapayment
     */
    protected $method;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @param PaymentHelper $paymentHelper
     * @param Escaper $escaper
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        PaymentHelper $paymentHelper,
        Escaper $escaper
    ) {
        $this->escaper = $escaper;
        $this->method = $paymentHelper->getMethodInstance($this->methodCode);
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'nodapayment' => [
                ],
            ],
        ] : [];
    }
}
