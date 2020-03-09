<?php

namespace Mageplaza\Giftcard\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;
use Zend\View\Helper\Url;
use Magento\Customer\Model\Session as CustomerSession;
use \Magento\Checkout\Model\Session as CheckoutSession;
use Mageplaza\Giftcard\Model\GiftcardFactory;

class Data extends AbstractHelper
{

    const XML_PATH_GIFTCARD = 'giftcard/';

    protected $_storeManager;

    protected $_urlBuilder;

    protected $_customerSession;

    protected $_checkoutSession;

    protected $_giftcardFactory;

    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        UrlInterface $urlBuilder,
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
        GiftcardFactory $giftcardFactory
    )
    {
        $this->_storeManager = $storeManager;
        $this->_urlBuilder = $urlBuilder;
        $this->_customerSession = $customerSession;
        $this->_checkoutSession = $checkoutSession;
        $this->_giftcardFactory = $giftcardFactory;

        return parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_GIFTCARD .'general/'. $code, $storeId);
    }

    public function getCodeConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_GIFTCARD .'code_config/'. $code, $storeId);
    }

    public function getRandomCode()
    {
        return strtoupper($this->unique_code());
    }

    public function unique_code()
    {
        $limit = $this->getCodeConfig('code_length');
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, (int)$limit);
    }

    public function isRedeemAllowed()
    {
        return $this->getGeneralConfig('allow_redeem_giftcard_checkout') ? true : false;
    }

    public function isModuleOn()
    {
        return $this->getGeneralConfig('enable_module') ? true : false;
    }

    public function isGiftcardCheckoutAllowed()
    {
        return $this->getGeneralConfig('allow_giftcard_checkout') ? true : false;
    }

    public function getCurrency()
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCurrencySymbol();
    }

    public function getBaseUrl()
    {
        return $this->_urlBuilder->getBaseUrl();
    }

    public function isRedeemable()
    {
        return $this->_customerSession->isLoggedIn() && $this->isModuleOn() && $this->isRedeemAllowed();
    }

    public function updateGiftcardQuote($code, $amount)
    {
        $this->_checkoutSession->getQuote()->setGiftcodeApply($code);
        $this->_checkoutSession->getQuote()->setGiftcardDiscount($amount);
    }

    public function getCustomerGiftcardByCode($code)
    {
        return $this->_giftcardFactory->create()
            ->getCollection()
            ->addFieldToFilter('code', $code)
            ->addFieldToFilter('customer_id', $this->_customerSession->getCustomerId())
            ->getFirstItem();
    }


}