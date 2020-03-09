<?php

namespace Mageplaza\Giftcard\Controller\Giftcode;

use Magento\Config\Model\Config\Backend\Admin\Custom;
use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Mageplaza\Giftcard\Model\GiftcardHistoryFactory;
use Mageplaza\Giftcard\Model\GiftcardFactory;
use Mageplaza\Giftcard\Helper\Data;
use Mageplaza\Giftcard\Model\ResourceModel\Giftcard as GiftcardResource;
use \Magento\Checkout\Model\Session as CheckoutSession;
use \Magento\Quote\Model\Quote\Address\Total;
use Mageplaza\Giftcard\Model\ResourceModel\Giftcard\Collection as GiftcardCollection;
use Magento\Framework\UrlInterface;

class Test extends Action
{
    protected $_pageFactory;

    protected $_checkoutSession;

    /**
     * @type \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @type \Magento\Payment\Model\Method\Factory
     */
    protected $_paymentMethodFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CheckoutSession $checkoutSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Factory $paymentMethodFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->_scopeConfig          = $scopeConfig;
        $this->_paymentMethodFactory = $paymentMethodFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}

