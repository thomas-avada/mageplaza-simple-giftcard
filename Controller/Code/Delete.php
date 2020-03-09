<?php
namespace Mageplaza\Giftcard\Controller\Code;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Mageplaza\Giftcard\Model\GiftcardFactory;

class Delete extends Action
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
        $params = $this->getRequest()->getParams();
        $code = $this->_giftcardFactory->create()->load($params['id']);
        if(!$code->isEmpty()){
            $code->delete();
            echo "Delele the giftcard code: ".$code->getCode()." succesfully";
        }else{
            echo "The giftcard does not exist";
        }

    }

}