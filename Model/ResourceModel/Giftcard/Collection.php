<?php
namespace Mageplaza\Giftcard\Model\ResourceModel\Giftcard;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'giftcard_id';
    protected $_eventPrefix = 'mageplaza_giftcard_collection';
    protected $_eventObject = 'giftcard_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mageplaza\Giftcard\Model\Giftcard', 'Mageplaza\Giftcard\Model\ResourceModel\Giftcard');
    }

    public function redeemGiftcard($giftcard)
    {
        $this->setAmountUsed($giftcard->getBalance())->save();
    }

}