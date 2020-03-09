<?php
namespace Mageplaza\Giftcard\Model\ResourceModel\GiftcardHistory;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'history_id';
    protected $_eventPrefix = 'mageplaza_giftcard_history_collection';
    protected $_eventObject = 'giftcard_history_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mageplaza\Giftcard\Model\GiftcardHistory', 'Mageplaza\Giftcard\Model\ResourceModel\GiftcardHistory');

    }

//    public function getGiftcards()
//    {
//        $giftcard = $this->getTable('giftcard_code');
//        $this->getSelect()
//            ->join(
//                [$giftcard],
//                $giftcard.'.giftcard_id = main_table.giftcard_id',
//                [
//                    'code' => $giftcard.'.code'
//                ]
//            );
////        echo $this->getSelect();
//    }

}