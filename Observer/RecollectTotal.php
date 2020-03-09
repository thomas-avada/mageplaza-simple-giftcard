<?php

namespace Mageplaza\Giftcard\Observer;

use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;
use \Magento\Checkout\Model\Session as CheckoutSession;


class RecollectTotal implements ObserverInterface
{

    protected $_checkoutSession;

    protected $quoteRepository;

    public function __construct(
        CheckoutSession $checkoutSession,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    )
    {
        $this->_checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
    }

    public function execute(Observer $observer)
    {
        $this->_checkoutSession->getQuote()->collectTotals()->save();
//        $this->quoteRepository->save($totals);
    }
}