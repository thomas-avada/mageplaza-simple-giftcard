<?php
namespace Mageplaza\Giftcard\Model\Api;

use Mageplaza\Giftcard\Api\GiftcardValidInterface;
use Mageplaza\Giftcard\Model\GiftcardFactory;

class GiftcardValid implements GiftcardValidInterface
{
    protected $_giftcardFactory;

    protected $resultJsonFactory;

    public function __construct(
        GiftcardFactory $giftcardFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->_giftcardFactory = $giftcardFactory;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function isValid($giftcode)
    {
        $giftcard = $this->_giftcardFactory->create()
            ->getCollection()
            ->addFieldToFilter('code', $giftcode)
            ->getFirstItem();
        if($giftcard->getId()){
            return json_encode([
                'message' => "Giftcard #$giftcode is valid"
            ]);
        }
        return json_encode([
            'message' => 'Giftcard not available'
        ]);
    }
}