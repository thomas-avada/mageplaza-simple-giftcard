<?php
namespace Mageplaza\Giftcard\Model\Api;

use Mageplaza\Giftcard\Api\GiftcardInterface;
use Mageplaza\Giftcard\Model\GiftcardFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\CartTotalRepositoryInterface;
use Magento\Checkout\Model\Session;

class Giftcard implements GiftcardInterface
{
    protected $_giftcardFactory;

    protected $checkoutSession;

    protected $cartTotalRepository;

    protected $cartRepository;

    public function __construct(
        GiftcardFactory $giftcardFactory,
        CartRepositoryInterface $cartRepository,
        CartTotalRepositoryInterface $cartTotalRepository,
        Session $checkoutSession
    )
    {
        $this->_giftcardFactory = $giftcardFactory;
        $this->cartRepository      = $cartRepository;
        $this->cartTotalRepository = $cartTotalRepository;
        $this->checkoutSession     = $checkoutSession;
    }

    public function calculate()
    {
        $quote = $this->checkoutSession->getQuote();
        $quote->collectTotals();
        $this->cartRepository->save($quote);

        return $this->cartTotalRepository->get($quote->getId());
    }
}