<?php

namespace Mageplaza\Giftcard\Observer;

use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;

class NewGiftcardCreated implements ObserverInterface
{

    public function execute(Observer $observer)
    {
        $_SESSION['newGiftcard'] = "Giftcard has been created";
    }
}