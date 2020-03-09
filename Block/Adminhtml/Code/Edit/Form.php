<?php
namespace Mageplaza\Giftcard\Block\Adminhtml\Code\Edit;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Backend\Block\Widget\Form\Generic;
use \Magento\Backend\Block\Template\Context as BackendContext;
use Mageplaza\Giftcard\Helper\Data;

class Form extends Generic
{

    protected $giftcardFactory;

    protected $helper;

    public function __construct(
        BackendContext $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Mageplaza\Giftcard\Model\GiftcardFactory $giftcardFactory,
        Data $helper,
        array $data = []
    ) {
        $this->giftcardFactory = $giftcardFactory;
        $this->helper = $helper;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form for render
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $form = $this->_formFactory->create();

        $giftcard_id = $this->_coreRegistry->registry('current_giftcard_id');

        if ($giftcard_id === null) {
            $giftcardData = $this->giftcardFactory->create();
        } else {
            $giftcardData = $this->giftcardFactory->create()->load($giftcard_id);
        }

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Giftcard Information')
        ]);

        $fieldset->addField(
            'customer_id',
            'text',
            [
                'name' => 'customer_id',
                'label' => __('Customer'),
                'title' => __('Customer'),
                'required' => false
            ]
        )->setAfterElementHtml(
            '<div id="customer-grid" style="display:none"></div>
                <script type="text/x-magento-init">
                    {
                        "#customer_id": {
                            "Mageplaza_Giftcard/js/view/customer":{
                                "url": "' . $this->getAjaxUrl() . '"
                            }
                        }
                    }
                </script>'
        );

        $fieldset->addField(
            'code_length',
            'text',
            [
                'name' => 'code_length',
                'label' => __('Code Length'),
                'title' => __('Code Length'),
                'required' => true,
                'disabled' => true,
                'value' => $this->helper->getCodeConfig('code_length')
            ]
        );
        $fieldset->addField(
            'balance',
            'text',
            [
                'name' => 'balance',
                'label' => __('Balance'),
                'title' => __('Balance'),
                'required' => true
            ]

        );

        if ($giftcardData->getGiftcardId() !== null) {
            // If edit add id
            $form->addField(
                'giftcard_id',
                'hidden',
                [
                    'name' => 'giftcard_id',
                    'value' => $giftcardData->getId()
                ]
            );
            $fieldset->removeField('code_length');
            $fieldset->addField(
                'code',
                'text',
                [
                    'name' => 'code',
                    'label' => __('Giftcard code'),
                    'title' => __('Giftcard code'),
                    'required' => true,
                    'disabled' => true
                ]
            );
            $fieldset->addField(
                'create_from',
                'text',
                [
                    'name' => 'create_from',
                    'label' => __('Create from'),
                    'title' => __('Create from'),
                    'required' => true,
                    'disabled' => true
                ]
            );

            $form->addValues([
                'balance' => $giftcardData->getBalance(),
                'create_from' => $giftcardData->getCreateFrom(),
                'code' => $giftcardData->getCode()
            ]);
        }

        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setMethod('post');
        $this->setForm($form);
    }

    /**
     * Get transaction grid url
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('mpreward/transaction/customergrid');
    }
}
