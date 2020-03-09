<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mageplaza\Giftcard\Model\Total\Invoice;

class GiftcardDiscount extends \Magento\Sales\Model\Order\Invoice\Total\AbstractTotal
{
    /**
     * Collect invoice subtotal
     *
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $order = $invoice->getOrder();

        $giftcardDiscount = $order->getGiftcardDiscount();

        $invoice->setGiftcardDiscount($giftcardDiscount);

        $invoice->setGrandTotal($invoice->getGrandTotal() - $giftcardDiscount);

        return $this;
    }
}
