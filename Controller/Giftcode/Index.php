<?php

namespace Mageplaza\Giftcard\Controller\Giftcode;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;
use Mageplaza\Giftcard\Helper\Data;

class Index extends Action
{
    protected $_pageFactory;

    protected $customerSession;

    protected $_helper;

    public function __construct(
        Context $context,
        Session $customerSession,
        PageFactory $pageFactory,
        Data $helper
    )
    {
        $this->customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        $this->_helper = $helper;
        return parent::__construct($context);
    }

    public function execute()
    {
        if($this->_helper->isModuleOn()){
            if(!$this->customerSession->isLoggedIn()){
                $this->messageManager->addError('You are not logined');
                return $this->_redirect($this->_helper->getBaseUrl().'customer/account/login/');
            }
            return $this->_pageFactory->create();
        }
        $this->messageManager->addError('This module is disabled');
        return $this->_redirect('customer/account/');
    }
}

