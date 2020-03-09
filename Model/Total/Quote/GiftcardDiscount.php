<?php
namespace Mageplaza\Giftcard\Model\Total\Quote;

use \Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use \Magento\Framework\Pricing\PriceCurrencyInterface;
use \Magento\Checkout\Model\Session as CheckoutSession;
use Mageplaza\Giftcard\Model\GiftcardFactory;

class GiftcardDiscount extends AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    protected $_checkoutSession;

    protected $_giftcardFactory;
    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        PriceCurrencyInterface $priceCurrency,
        CheckoutSession $checkoutSession,
        GiftcardFactory $giftcardFactory
    )
    {
        $this->_priceCurrency = $priceCurrency;
        $this->_checkoutSession = $checkoutSession;
        $this->_giftcardFactory = $giftcardFactory;
    }
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|bool
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        //Stop the giftcard from being applied twice
        $items = $shippingAssignment->getItems();
        if (!count($items)) {
            return $this;
        }

        //The actual total calculation
        parent::collect($quote, $shippingAssignment, $total);
        $code = $this->_checkoutSession->getQuote()->getGiftcodeApply();
        $giftcard = $this->_giftcardFactory->create()->load($code, 'code');
        $amount = $giftcard->getBalance() - $giftcard->getAmountUsed();
        $subTotal = $this->_checkoutSession->getQuote()->getSubtotal();
        if($amount > $subTotal){
            $amount = $subTotal;
            $this->_checkoutSession->getQuote()->setGiftcardDiscount($amount);
        }
        else {
            $this->_checkoutSession->getQuote()->setGiftcardDiscount($amount);
        }
        $baseDiscount = $this->_checkoutSession->getQuote()->getGiftcardDiscount();
        $discount = $this->_priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('giftcard_discount', -$discount);
        $total->addBaseTotalAmount('giftcard_discount', -$baseDiscount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
//        $this->_checkoutSession->setCustomDiscount($baseDiscount);
        return $this;
    }

    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return $totals[] = [
            'code' => 'giftcard_discount',
            'title' => __('Giftcard'),
            'value' => $this->_checkoutSession->getQuote()->getGiftcardDiscount()
        ];
    }
}