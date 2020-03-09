<?php

namespace Mageplaza\Giftcard\Controller\Giftcode;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;
use Mageplaza\Giftcard\Helper\Data;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResource;
use Mageplaza\Giftcard\Model\GiftcardFactory;
use Mageplaza\Giftcard\Model\GiftcardHistoryFactory;
use Magento\Customer\Model\CustomerFactory;
use \Magento\Checkout\Model\Session as CheckoutSession;

class Redeem extends Action
{
    protected $_pageFactory;

    protected $customerSession;

    protected $_helper;

    protected $customerResourceModel;

    protected $_giftcardFactory;

    protected $_giftcardHistoryFactory;

    protected $_customerFactory;

    protected $_storeManager;

    protected $_checkoutSession;

    protected $_resultJsonFactory;

    public function __construct(
        Context $context,
        Session $customerSession,
        PageFactory $pageFactory,
        Data $helper,
        GiftcardFactory $giftcardFactory,
        GiftcardHistoryFactory $giftcardHistoryFactory,
        CustomerResource $customerResourceModel,
        CustomerFactory $customerFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CheckoutSession $checkoutSession,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        $this->_helper = $helper;
        $this->_giftcardFactory = $giftcardFactory;
        $this->_giftcardHistoryFactory = $giftcardHistoryFactory;
        $this->customerResourceModel = $customerResourceModel;
        $this->_customerFactory = $customerFactory;
        $this->_storeManager = $storeManager;
        $this->_checkoutSession = $checkoutSession;
        $this->_resultJsonFactory = $resultJsonFactory;

        return parent::__construct($context);
    }

    public function execute()
    {
        if($this->_helper->isRedeemable()) {
            $redeemCode = $this->getCouponCode();
            //test if the giftcard exists
            $giftcard = $this->_helper->getCustomerGiftcardByCode($redeemCode);
            if (!$giftcard->isEmpty()) {
                //If exists, save and add balance
                $amount = $giftcard->getBalance() - $giftcard->getAmountUsed();
                if ($amount <= 0) {
                    $this->messageManager->addError('Not enough amount for redeeming');
                    return $this->_redirect('*/*/');
                }

                $this->updateCustomerBalance($amount);

                $this->createHistory($giftcard, $amount);

                $giftcard->setAmountUsed($giftcard->getBalance())->save();

                //Check if the giftcard is applied before redemption
                if($this->_checkoutSession->getQuote()->getGiftcardDiscount()){
                    $this->_helper->updateGiftcardQuote(null, 0);
                }

                return $this->_redirect('*/*/');
            }
            //If not, return back with message
            $this->messageManager->addError('This giftcard does not exist');
            return $this->_redirect('*/*/');
        }

        $result = $this->_resultJsonFactory->create();
        $result->setHttpResponseCode(403);
        return $result->setData([
            'error' => 'Redeeming action is not allowed',
            'status_code' => 403
        ]);
    }

    public function getCustomerId()
    {
        return $this->customerSession->getCustomerId();
    }

    public function getCustomer()
    {
        return $this->_customerFactory->create()->load($this->getCustomerId());
    }

    public function getGiftcard($code)
    {
        return $this->_giftcardFactory->create()
            ->getCollection()
            ->addFieldToFilter('code', $code)
            ->addFieldToFilter('customer_id', $this->customerSession->getCustomerId())
            ->getFirstItem();
    }

    public function updateCustomerBalance($amount)
    {
        $this->customerResourceModel->getConnection()->update(
            $this->customerResourceModel->getTable('customer_entity'),
            [
                'giftcard_balance' => $this->getCustomer()->getGiftcardBalance() + $amount
            ],
            $this->customerResourceModel->getConnection()->quoteInto('entity_id = ?', $this->getCustomerId())
        );
    }

    public function createHistory($giftcard, $amount)
    {
        $this->_giftcardHistoryFactory->create()->setData([
            'giftcard_id' => $giftcard->getId(),
            'customer_id' => $this->getCustomerId(),
            'amount' => $amount,
            'action' => 'Redeem'
        ])->save();
    }

    public function getCouponCode()
    {
        return strtoupper(
            trim(
                $this->getRequest()->getParam('redeem')
            )
        );
    }
}

