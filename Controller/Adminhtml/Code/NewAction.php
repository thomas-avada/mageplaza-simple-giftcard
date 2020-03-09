<?php
namespace Mageplaza\Giftcard\Controller\Adminhtml\Code;

use \Magento\Backend\App\Action as BackendAction;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Registry;
use \Mageplaza\Giftcard\Model\GiftcardFactory;

class NewAction extends BackendAction
{
    protected $resultPageFactory = false;

    protected $_coreRegistry;

    protected $_giftcardFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        GiftcardFactory $giftcardFactory
    )
    {
        $this->_giftcardFactory = $giftcardFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $giftcard_id = $this->getRequest()->getParam('id');
        
        $this->_coreRegistry->register('current_giftcard_id', $giftcard_id);

        $resultPage = $this->resultPageFactory->create();
        if ($giftcard_id === null) {
            $resultPage->getConfig()->getTitle()->prepend(__('New giftcard'));
        } else {
            //If the edit giftcard does not exist, back to index
            if($this->_giftcardFactory->create()->load($giftcard_id)->getId() === null){
                $this->messageManager->addError('This giftcard is currently not available');
//                return $this->_redirect('*/*/');
                return $this->_redirect('*/*/');
            }
            $resultPage->getConfig()->getTitle()->prepend(__('Edit giftcard'));
        }

        return $resultPage;
    }


}