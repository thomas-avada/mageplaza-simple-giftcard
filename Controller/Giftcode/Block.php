<?php

namespace Mageplaza\Giftcard\Controller\Giftcode;

use Magento\Config\Model\Config\Backend\Admin\Custom;
use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Mageplaza\Giftcard\Model\GiftcardHistoryFactory;
use Mageplaza\Giftcard\Model\GiftcardFactory;
use Mageplaza\Giftcard\Helper\Data;
use Mageplaza\Giftcard\Model\ResourceModel\Giftcard as GiftcardResource;
use \Magento\Checkout\Model\Session as CheckoutSession;
use \Magento\Quote\Model\Quote\Address\Total;
use Mageplaza\Giftcard\Model\ResourceModel\Giftcard\ByAdmin\Collection as GiftcardCollection;
use Magento\Framework\UrlInterface;

class Block extends Action
{
    protected $_pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        return $resultPage;
    }
}

