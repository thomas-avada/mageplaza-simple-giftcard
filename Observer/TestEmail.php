<?php

namespace Mageplaza\Giftcard\Observer;

use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer;
use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\Store;
use Magento\Email\Model\Template\SenderResolver;

class TestEmail implements ObserverInterface
{
    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var SenderResolver
     */
    protected $senderResolver;

    public function __construct(
        TransportBuilder $transportBuilder,
        SenderResolver $senderResolver
    )
    {
        $this->_transportBuilder = $transportBuilder;
        $this->senderResolver    = $senderResolver;
    }

    public function execute(Observer $observer)
    {
        $from = $this->senderResolver->resolve(
            ['name' => 'Tuananh', 'email' => 'test@magento.com']
        );

        $this->_transportBuilder
            ->setTemplateIdentifier('test_email_magento')
            ->setTemplateOptions(['area' => Area::AREA_FRONTEND, 'store' => Store::DEFAULT_STORE_ID])
            ->setTemplateVars([
                'name' => 'Thomas',
                'from' => 'Magento 2'
            ])
            ->setFrom($from)
            ->addTo('chelseatuananhnd99@gmail.com');

        $this->_transportBuilder->getTransport()->sendMessage();
    }
}