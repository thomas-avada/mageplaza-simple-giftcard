<?php
namespace Mageplaza\Giftcard\Api;

interface SpendPointInterface
{
    /**
     * Returns greeting message to user
     * @param int $point
     * @api
     * @return \Magento\Quote\Api\Data\TotalsInterface
     */
    public function calculate($point);

}