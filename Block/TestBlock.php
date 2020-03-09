<?php
namespace Mageplaza\Giftcard\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class TestBlock extends Template
{


    public function __construct(
        Template\Context $context
    )
    {
        parent::__construct($context);
    }


}
