<?php

namespace Mageplaza\Giftcard\Plugin;

use Mageplaza\Giftcard\Model\Total\Quote\Custom as CustomDiscount;
use Mageplaza\Giftcard\Model\GiftcardFactory;
use \Magento\Checkout\Model\Session as CheckoutSession;

class GiftcodeDiscount
{
    protected $_giftcardFactory;

    protected $_checkoutSession;

    public function __construct(
        GiftcardFactory $giftcardFactory,
        CheckoutSession $checkoutSession
    )
    {
        $this->_giftcardFactory = $giftcardFactory;
        $this->_checkoutSession = $checkoutSession;
    }

    public function beforeSetBaseDiscount(CustomDiscount $subject, $discount)
    {
//        if($this->_checkoutSession->getGiftcodeApply()){
//            $giftcard = $this->_giftcardFactory->create()
//                ->load($this->_checkoutSession->getGiftcodeApply(), 'code');
//            $discount = $giftcard->getBalance() - $giftcard->getAmountUsed();
//            return [$discount];
//        }
        $discount =1;
        return [$discount];
    }

//    public function afterGetBaseDiscount(CustomDiscount $subject, $result)
//    {
//        if($this->_checkoutSession->getGiftcodeApply()){
//            $giftcard = $this->_giftcardFactory->create()
//                ->load($this->_checkoutSession->getGiftcodeApply(), 'code');
//
//            $discount = $giftcard->getBalance() - $giftcard->getAmountUsed();
//            return $result = $discount;
//        }
//        return $result;
//    }

}