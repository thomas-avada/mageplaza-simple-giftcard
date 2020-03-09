<?php
namespace Mageplaza\Giftcard\Controller\Code;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Mageplaza\Giftcard\Model\GiftcardFactory;

class Store extends Action
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
        $data = $this->getRequest()->getParams();
        $data['code'] = '8738HG52F1';
        $new = $this->_giftcardFactory->create()->setData($data)->save();
        var_dump($new->getData());
    }

}