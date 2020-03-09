<?php
namespace Mageplaza\Giftcard\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

class Giftcard extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'mageplaza_giftcard';

    protected $_cacheTag = 'mageplaza_giftcard';

    protected $_eventPrefix = 'mageplaza_giftcard';

    protected function _construct()
    {
        $this->_init('Mageplaza\Giftcard\Model\ResourceModel\Giftcard');
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