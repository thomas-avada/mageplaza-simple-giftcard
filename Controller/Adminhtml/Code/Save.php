<?php
namespace Mageplaza\Giftcard\Controller\Adminhtml\Code;

use Magento\Backend\App\Action as BackendAction;
use \Magento\Backend\App\Action\Context as BackendContext;
use \Mageplaza\Giftcard\Model\GiftcardFactory;
use Mageplaza\Giftcard\Helper\Data;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResource;
use Mageplaza\Giftcard\Model\GiftcardHistoryFactory;

class Save extends BackendAction
{
    private $giftcardFactory;

    protected $_coreRegistry;

    protected $resultForwardFactory;

    protected $resultPageFactory;

    protected $_giftcardHistoryFactory;

    protected $_customerFactory;

    protected $customerResourceModel;

    public function __construct(
        BackendContext $context,
        \Magento\Framework\Registry $coreRegistry,
        GiftcardFactory $giftcardFactory,
        GiftcardHistoryFactory $giftcardHistoryFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Data $helper,
        CustomerFactory $customerFactory,
        CustomerResource $customerResourceModel
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->giftcardFactory = $giftcardFactory;
        $this->_giftcardHistoryFactory = $giftcardHistoryFactory;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
        $this->_customerFactory = $customerFactory;
        $this->customerResourceModel = $customerResourceModel;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('giftcard_id');
        try {
            $data = $this->getRequest()->getParams();
            if ($id !== null) {
                $giftcardData = $this->giftcardFactory->create()->load((int)$id);
                $giftcardData->setData($data)->save();
            } else {
                $giftcardData = $this->giftcardFactory->create();
                $data['code'] = $this->helper->getRandomCode();
                $giftcardData->setData($data)->save();

                //Save to history
                $this->_giftcardHistoryFactory->create()->setData([
                    'giftcard_id' => $giftcardData->getId(),
                    'customer_id' => $data['customer_id'],
                    'amount' => $giftcardData->getBalance(),
                    'action' => 'Created by admin'
                ])->save();
            }

            $this->messageManager->addSuccess(__('Saved giftcard item.'));
            if($this->getRequest()->getParam('back')){
                return $this->_redirect('giftcard/code/edit', ['id' => $giftcardData->getGiftcardId()]);
            }
            return $this->_redirect('giftcard/code/');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());

            return $this->_redirect('giftcard/code/edit', ['id' => $id]);
        }
    }
}
