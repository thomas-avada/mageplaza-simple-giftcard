<?php
namespace Mageplaza\Giftcard\Model\Api;

use Mageplaza\Giftcard\Api\SpendPointInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\CartTotalRepositoryInterface;
use Magento\Checkout\Model\Session;

class SpendPoint implements SpendPointInterface
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

    /**
     * Returns greeting message to user
     * @param int $point
     * @api
     * @return \Magento\Quote\Api\Data\TotalsInterface
     */
    public function calculate($point)
    {
        $quote = $this->checkoutSession->getQuote();
        $quote->setMpRewardSpent($point);
        $quote->collectTotals();
        $this->cartRepository->save($quote);

        return $this->cartTotalRepository->get($quote->getId());
    }

}