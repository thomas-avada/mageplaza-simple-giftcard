<?php
namespace Mageplaza\Giftcard\Controller\Config;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Mageplaza\Giftcard\Helper\Config;

class Index extends Action
{
    protected $_pageFactory;

    protected $_helperConfig;

    public function __construct(Context $context, PageFactory $pageFactory, Config $helperConfig)
    {
        $this->_pageFactory = $pageFactory;
        $this->_helperConfig = $helperConfig;
        return parent::__construct($context);
    }

    public function execute()
    {
        echo $this->_helperConfig->getCodeConfig('code_length');
    }

}