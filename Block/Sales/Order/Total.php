<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_RewardPoints
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\Giftcard\Block\Sales\Order;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mageplaza\RewardPoints\Helper\Data as HelperData;

/**
 * Class Total
 * @package Mageplaza\RewardPoints\Block\Sales\Order
 */
class Total extends Template
{
    /**
     * Total constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * Init Totals
     */
    public function initTotals()
    {
        /** @var \Magento\Sales\Block\Order\Totals $totalsBlock */
        $totalsBlock = $this->getParentBlock();
        $source      = $totalsBlock->getSource();
        if ($source) {
            if(get_class($source) == 'Magento\Sales\Model\Order\Interceptor') {
                if ($source->getGiftcardDiscount() > 0) {
                    $totalsBlock->addTotal(new DataObject([
                        'code' => 'giftcard_discount',
                        'field' => 'giftcard_discount',
                        'label' => 'Giftcard Discount',
                        'value' => -$source->getGiftcardDiscount()
                    ]), 'subtotal');
                }
            }
            if(get_class($source) == 'Magento\Sales\Model\Order\Invoice'){
                if ($source->getOrder()->getGiftcardDiscount() > 0) {
                    $totalsBlock->addTotal(new DataObject([
                        'code'  => 'giftcard_discount',
                        'field' => 'giftcard_discount',
                        'label' => 'Giftcard Discount',
                        'value' => -$source->getOrder()->getGiftcardDiscount()
                    ]), 'subtotal');
                }
            }
            if(get_class($source) == 'Magento\Sales\Model\Order\Creditmemo'){
                if ($source->getOrder()->getGiftcardDiscount() > 0) {
                    $totalsBlock->addTotal(new DataObject([
                        'code'  => 'giftcard_discount',
                        'field' => 'giftcard_discount',
                        'label' => 'Giftcard Discount',
                        'value' => -$source->getOrder()->getGiftcardDiscount()
                    ]), 'subtotal');
                }
            }

        }
    }
}
