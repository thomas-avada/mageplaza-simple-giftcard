<?php
namespace Mageplaza\Giftcard\Controller\Adminhtml\Code;

use \Magento\Backend\App\Action as BackendAction;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Index extends BackendAction
{
	protected $resultPageFactory = false;

	protected $giftcardFactory;

	public function __construct(
		Context $context, 
		PageFactory $resultPageFactory
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__('GiftCodes')));

		return $resultPage;
	}


}