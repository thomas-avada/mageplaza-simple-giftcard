<?php
namespace Mageplaza\Giftcard\Controller\Code;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Mageplaza\Giftcard\Model\GiftcardFactory;

class Index extends Action
{
    protected $_pageFactory;

    protected  $_giftcardFactory;

    public function __construct(Context $context, PageFactory $pageFactory, GiftcardFactory $giftcardFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_giftcardFactory = $giftcardFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $codes = $this->_giftcardFactory->create()->getCollection()->getData();

        var_dump($codes);
    }

}