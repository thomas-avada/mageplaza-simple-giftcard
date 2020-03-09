<?php
namespace Mageplaza\Giftcard\Model\Total\Quote;

use \Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use \Magento\Framework\Pricing\PriceCurrencyInterface;

class Custom extends AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    protected $_baseDiscount = 0;
    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(PriceCurrencyInterface $priceCurrency)
    {
        $this->_priceCurrency = $priceCurrency;
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
        parent::collect($quote, $shippingAssignment, $total);
        $baseDiscount = $this->setBaseDiscount(10)->getBaseDiscount();
        $discount =  $this->_priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('customdiscount', -$discount);
        $total->addBaseTotalAmount('customdiscount', -$baseDiscount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
        $quote->setCustomDiscount(-$discount);
        return $this;
    }

    public function setBaseDiscount($discount)
    {
        $this->_baseDiscount = $discount;
        return $this;
    }

    public function getBaseDiscount()
    {
        return $this->_baseDiscount;
    }
}