<?php
namespace Mageplaza\Giftcard\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

class GiftcardHistory extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'mageplaza_giftcard_history';

    protected $_cacheTag = 'mageplaza_giftcard_history';

    protected $_eventPrefix = 'mageplaza_giftcard_history';

    protected $_orderCurrency = null;

    protected function _construct()
    {
        $this->_init('Mageplaza\Giftcard\Model\ResourceModel\GiftcardHistory');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

}