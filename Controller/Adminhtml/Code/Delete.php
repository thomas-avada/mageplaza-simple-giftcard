<?php
namespace Mageplaza\Giftcard\Controller\Adminhtml\Code;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Mageplaza\Giftcard\Model\GiftcardFactory;

class Delete extends BackendAction
{
    protected $giftcardFactory;

    public function __construct(Context $context, GiftcardFactory $giftcardFactory)
    {
        $this->giftcardFactory = $giftcardFactory;
        parent::__construct($context);
    }
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->giftcardFactory->create()->load($id)->delete();
                // display success message
                $this->messageManager->addSuccess(__('The item has been deleted.'));
                // go to grid
                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $this->_redirect('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a listing to delete.'));
        // go to grid
        return $this->_redirect('*/*/');
    }
}
