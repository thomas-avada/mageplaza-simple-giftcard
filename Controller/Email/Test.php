<?php

namespace Mageplaza\Giftcard\Controller\Email;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\Store;
use Mageplaza\Smtp\Mail\Rse\Mail;
use Psr\Log\LoggerInterface;
use Magento\Email\Model\Template\SenderResolver;
use Mageplaza\RewardPoints\Helper\Data;

class Test extends Action
{
    protected $_pageFactory;

    protected $_helper;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Data $helper
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        echo $this->_helper->getConfigGeneral('slider_color_scheme');
    }
}

