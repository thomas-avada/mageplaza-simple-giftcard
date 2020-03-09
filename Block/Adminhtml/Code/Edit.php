<?php
namespace Mageplaza\Giftcard\Block\Adminhtml\Code;

use Magento\Backend\Block\Widget\Form\Container;
use \Magento\Backend\Block\Widget\Context;
use \Magento\Framework\Registry;

class Edit extends Container
{

    protected $coreRegistry;

    protected $giftcard_id=false;

    public function __construct(Context $context, Registry $registry, array $data = [])
    {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Remove Delete button if record can't be deleted.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'giftcard_id';
        $this->_controller = 'adminhtml_code';
        $this->_blockGroup = 'Mageplaza_Giftcard';

        parent::_construct();

        $giftcard_id = $this->getGiftcardId();
        if($giftcard_id){
            $this->addButton(
                'delete',
                [
                    'label' => __('Delete Giftcard'),
                    'class' => 'delete',
                    'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to delete this giftcard?'))
                        . ','
                        . json_encode(
                            $this->getUrl(
                                '*/*/delete',
                                ['id' => $giftcard_id]
                            )
                        )
                        . ')',
                    'sort_order' => 20
                ],
                10
            );
        }

        $this->addButton(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ],
                ]
            ],
            10
        );

    }

    /**
     * Retrieve the header text, either editing an existing record or creating a new one.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        $giftcard_id = $this->getGiftcardId();
        if (!$giftcard_id) {
            return __('New Giftcard Item');
        } else {
            return __('Edit Giftcard Item');
        }
    }

    public function getGiftcardId()
    {
        if (!$this->giftcard_id) {
            $this->giftcard_id=$this->coreRegistry->registry('current_giftcard_id');
        }
        return $this->giftcard_id;
    }

}
