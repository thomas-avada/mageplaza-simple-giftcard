<?php

namespace Mageplaza\Giftcard\Observer;

use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;
use Mageplaza\Giftcard\Model\GiftcardHistoryFactory;
use Mageplaza\Giftcard\Model\GiftcardFactory;
use Mageplaza\Giftcard\Helper\Data;
use \Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\ProductFactory;
use Magento\Customer\Model\Session as CustomerSession;

class CreateGiftcard implements ObserverInterface
{
    protected $_giftcardHistoryFactory;

    protected $_giftcardFactory;

    protected $helper;

    protected $_cart;

    protected $_productFactory;

    protected $_customerSession;

    public function __construct(
        GiftcardHistoryFactory $giftcardHistory,
        GiftcardFactory $giftcardFactory,
        Data $helper,
        Cart $cart,
        ProductFactory $productFactory,
        CustomerSession $customerSession
    )
    {
        $this->_giftcardFactory = $giftcardFactory;
        $this->_giftcardHistoryFactory = $giftcardHistory;
        $this->helper = $helper;
        $this->_cart = $cart;
        $this->_productFactory = $productFactory;
        $this->_customerSession = $customerSession;
    }

    public function execute(Observer $observer)
    {
        foreach ($this->_cart->getItems() as $item){
            $product = $this->_productFactory->create()->load($item->getProduct()->getId());
            if($item->getProduct()->getTypeId() == 'virtual' && $product->getGiftcardAmount()){
                $increment_id = $observer->getData('order')->getIncrementId();
                $count = $item->getQty();
                $amount = $product->getGiftcardAmount();
                for($i= 0; $i < $count; $i++){
                    $giftcard = $this->_giftcardFactory->create()->setData([
                        'code' => $this->helper->getRandomCode(),
                        'balance' => $amount,
                        'create_from' => "Order #$increment_id"
                    ])->save();
                    $this->_giftcardHistoryFactory->create()->setData([
                        'giftcard_id' => $giftcard->getId(),
                        'customer_id' => $this->_customerSession->getCustomerId(),
                        'amount' => $giftcard->getBalance(),
                        'action' => "Created by #$increment_id"
                    ])->save();
                }
            }
        }

    }
}