<?php

namespace Mageplaza\Giftcard\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

class SalesConvertQuote implements ObserverInterface
{

    public function execute(Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();

        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        $order->setGiftcardDiscount($quote->getGiftcardDiscount());

        return $this;
    }
}
