<?php

namespace Mageplaza\Giftcard\Plugin;

use Magento\Checkout\Block\Cart\Coupon;
use \Magento\Checkout\Model\Session as CheckoutSession;

class ApplyGiftcode
{
    protected $_checkoutSession;

    public function __construct(CheckoutSession $checkoutSession)
    {
        $this->_checkoutSession = $checkoutSession;
    }

    public function afterGetCouponCode(Coupon $subject, $result)
    {
        $code = $this->_checkoutSession->getQuote()->getGiftcodeApply();
        if($code){
            return $result = $code;
        }
        return $result;
    }
}