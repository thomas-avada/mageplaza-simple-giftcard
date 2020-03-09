<?php

namespace Mageplaza\Giftcard\Observer;

use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;
use Mageplaza\Giftcard\Model\GiftcardFactory;
use \Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\ActionInterface;
use \Magento\Checkout\Model\Session as CheckoutSession;
use \Magento\Framework\App\ResponseInterface;
use Mageplaza\Giftcard\Helper\Data;

class ApplyGiftcode implements ObserverInterface
{
    protected $messageManager;

    protected $_actionFlag;

    protected $_checkoutSession;

    protected $_response;

    protected $_helper;

    protected $_customerSession;

    public function __construct(
        ManagerInterface $messageManager,
        ActionFlag $actionFlag,
        CheckoutSession $checkoutSession,
        ResponseInterface $response,
        Data $helper,
        CustomerSession $customerSession
    )
    {
        $this->messageManager = $messageManager;
        $this->_actionFlag = $actionFlag;
        $this->_checkoutSession = $checkoutSession;
        $this->_response = $response;
        $this->_helper = $helper;
    }

    public function execute(Observer $observer)
    {
        if($this->_helper->isGiftcardCheckoutAllowed()){
            $controller = $observer->getControllerAction();
            $remove = $controller->getRequest()->getParam('remove');

            $code = $this->getCouponCode($controller);
            $giftcard = $this->_helper->getCustomerGiftcardByCode($code);
            //Check giftcard existence, if not, go to couponPost
            if(!$giftcard->isEmpty()){
                $amount= $giftcard->getBalance() - $giftcard->getAmountUsed();
                $this->_actionFlag->set('', ActionInterface::FLAG_NO_DISPATCH, true);
                if(!$remove){
                    if($amount <= 0){
                        $this->messageManager->addError('Giftcard amount is empty');
                        return $this->_response->setRedirect('*/*/');
                    }
//                    $this->setDiscount($code, $amount);
                    $this->_helper->updateGiftcardQuote($code, $amount);
                    $this->_checkoutSession->getQuote()->collectTotals()->save();
                    $this->messageManager->addSuccess('Apply a giftcard successfully');
                    return $this->_response->setRedirect('*/*/');
                }
                $this->messageManager->addSuccess('Cancel applying a giftcard');
                $this->_helper->updateGiftcardQuote(null, 0);

                $this->_checkoutSession->getQuote()->collectTotals()->save();
                return $this->_response->setRedirect('*/*/');
            }
        }
    }

    public function getCouponCode($controller)
    {
        return strtoupper(
            trim(
                $controller->getRequest()->getParam('coupon_code')
            )
        );
    }
}