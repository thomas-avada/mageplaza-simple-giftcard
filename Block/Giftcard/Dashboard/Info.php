<?php
namespace Mageplaza\Giftcard\Block\Giftcard\Dashboard;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Customer\Model\CustomerFactory;
use Mageplaza\Giftcard\Helper\Data;
use Magento\Customer\Model\Session;

class Info extends Template
{

    protected $_customer;

    protected $_helper;

    protected $_customerSession;

    public function __construct(
        Template\Context $context,
        CustomerFactory $customer,
        Session $customerSession,
        Data $helper
    )
    {
        $this->_customer = $customer;
        $this->_helper = $helper;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function getBalance()
    {
        return $this->_customer->create()->getCollection()
        ->addFieldToFilter('entity_id', $this->_customerSession->getCustomerId())
        ->getFirstItem()
        ->getGiftcardBalance();
    }

    public function isRedeemAllowed()
    {
        return $this->_helper->isRedeemAllowed();
    }

    public function getBaseUrl()
    {
        return $this->_helper->getBaseUrl();
    }

}
