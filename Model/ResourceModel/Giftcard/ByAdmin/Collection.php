<?php
namespace Mageplaza\Giftcard\Model\ResourceModel\Giftcard\ByAdmin;

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

    /**
     * {@inheritdoc}
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->addFieldToFilter('create_from', 'admin');

        return $this;
    }



}