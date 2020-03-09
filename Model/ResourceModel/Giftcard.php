<?php
namespace Mageplaza\Giftcard\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use \Magento\Framework\Model\ResourceModel\Db\Context;

class Giftcard extends AbstractDb
{

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('giftcard_code', 'giftcard_id');
    }

    /**
     * Returns giftcard to user
     *
     * @api
     * @param string $name Users name.
     * @return string Giftcard result test
     */
    public function show($giftcard_id) {
        return "You are looking for giftcard with id: ".$giftcard_id;
    }

}