<?php
namespace Mageplaza\Giftcard\Model;

use Mageplaza\Giftcard\Api\HelloInterface;

class Hello implements HelloInterface
{
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     *@return array
     */
    public function name($name) {

        $message = new \Magento\Framework\DataObject([
            'message' => 'This works',
            'something' => 'ksdkfhjksdhf'
        ]);
        return [
            'message' => "Hello works"
        ];

    }
}