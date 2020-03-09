<?php

namespace Mageplaza\Giftcard\Block\Html;

use \Magento\Framework\View\Element\Template\Context;
use \Mageplaza\Giftcard\Helper\Data;

class Link extends \Magento\Framework\View\Element\Html\Link
{
    protected $helper;

    public function __construct(
        Context $context,
        Data $helper,
        array $data = []
    )
    {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    protected function _toHtml()
    {
        if ($this->helper->getGeneralConfig('giftcard_toplink') == true) {
            return parent::_toHtml();
        }

        return '';
    }
}