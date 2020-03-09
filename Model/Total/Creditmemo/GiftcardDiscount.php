<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mageplaza\Giftcard\Model\Total\Creditmemo;

class GiftcardDiscount extends \Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal
{
    /**
     * Collect invoice subtotal
     *
     * @param \Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Creditmemo  $creditmemo)
    {
        $order = $creditmemo->getOrder();

        $giftcardDiscount = $order->getGiftcardDiscount();

        $creditmemo->setGiftcardDiscount($giftcardDiscount);

        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() - $giftcardDiscount);

        return $this;
    }
}
