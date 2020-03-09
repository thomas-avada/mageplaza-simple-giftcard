<?php

namespace Mageplaza\Giftcard\Observer;

use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;
use Mageplaza\Giftcard\Model\GiftcardHistoryFactory;
use Mageplaza\Giftcard\Model\GiftcardFactory;
use Mageplaza\Giftcard\Helper\Data;
use \Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\ProductFactory;
use \Magento\Checkout\Model\Session as CheckoutSession;

class Test implements ObserverInterface
{
    protected $_giftcardHistoryFactory;

    protected $_giftcardFactory;

    protected $helper;

    protected $_cart;

    protected $_productFactory;

    protected $_checkoutSession;

    public function __construct(
        GiftcardHistoryFactory $giftcardHistory,
        GiftcardFactory $giftcardFactory,
        Data $helper,
        Cart $cart,
        ProductFactory $productFactory,
        CheckoutSession $checkoutSession,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->_giftcardFactory = $giftcardFactory;
        $this->_giftcardHistoryFactory = $giftcardHistory;
        $this->helper = $helper;
        $this->_cart = $cart;
        $this->_productFactory = $productFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute(Observer $observer)
    {
        $giftcard = $this->_giftcardFactory->create()->getCollection()->getData();
        $result = $this->resultJsonFactory->create();
        $result->setHttpResponseCode(200);
        $result->setJsonData(
            json_encode($giftcard)
        );
        return $result;
    }
}