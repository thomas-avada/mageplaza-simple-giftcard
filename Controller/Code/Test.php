<?php

namespace Mageplaza\Giftcard\Controller\Code;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Mageplaza\Giftcard\Helper\Data;

class Test extends Action
{
    protected $_pageFactory;

    protected $customerSession;

    protected $_helper;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Data $helper
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_helper = $helper;
        return parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}

