<?php
namespace Mageplaza\Giftcard\Block\Giftcard\Dashboard;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Mageplaza\Giftcard\Model\GiftcardHistoryFactory;
use Mageplaza\Giftcard\Model\GiftcardFactory as Giftcard;
use Magento\Customer\Model\Session;

class History extends Template
{

    protected $_giftcardFactory;

    protected  $_giftcardHistoryFactory;

    protected $_customerSession;

    public function __construct(
        Template\Context $context,
        Giftcard $giftcardFactory,
        GiftcardHistoryFactory $giftcardHistoryFactory,
        Session $customerSession
    )
    {
        $this->_customerSession = $customerSession;
        $this->_giftcardFactory = $giftcardFactory;
        $this->_giftcardHistoryFactory = $giftcardHistoryFactory;
        parent::__construct($context);
    }

    public function getGiftcards()
    {
        $giftcards = $this->_giftcardFactory->create();
        $history = $this->_giftcardHistoryFactory->create()
            ->getCollection()
            ->addFieldToFilter('customer_id', $this->_customerSession->getCustomerId());
        $array = [];
        foreach ($history as $item){
            $code = $giftcards->load($item->getGiftcardId())->getCode();
            $item->setCode($code);
            $array[] = $item;
        }
        return $array;
    }

}
