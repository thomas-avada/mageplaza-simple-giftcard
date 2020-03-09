<?php

namespace Mageplaza\Giftcard\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use \Mageplaza\Giftcard\Model\GiftcardFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    protected $_giftcardFactory;

    /**
     * @var QuoteSetupFactory
     */
    protected $quoteSetupFactory;

    /**
     * @var SalesSetupFactory
     */
    protected $salesSetupFactory;

    public function __construct(
        GiftcardFactory $giftcardFactory,
        QuoteSetupFactory $quoteSetupFactory,
        SalesSetupFactory $salesSetupFactory
    )
    {
        $this->_giftcardFactory = $giftcardFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
        $this->salesSetupFactory = $salesSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $quoteInstaller = $this->quoteSetupFactory->create(['resourceName' => 'quote_setup', 'setup' => $installer]);
        $salesInstaller = $this->salesSetupFactory->create(['resourceName' => 'sales_setup', 'setup' => $setup]);


        $quoteInstaller->addAttribute('quote', 'giftcard_discount', ['type' => Table::TYPE_INTEGER, 'length' => 10]);
        $quoteInstaller->addAttribute('quote', 'giftcode_apply', ['type' => Table::TYPE_TEXT, 'length' => 100]);

        $salesInstaller->addAttribute('order', 'giftcard_discount', ['type' => Table::TYPE_INTEGER, 'length' => 10]);
        $salesInstaller->addAttribute('order_item', 'giftcard_discount', ['type' => Table::TYPE_INTEGER, 'length' => 10]);
        $salesInstaller->addAttribute('invoice', 'giftcard_discount', ['type' => Table::TYPE_INTEGER, 'length' => 10]);
        $salesInstaller->addAttribute('creditmemo', 'giftcard_discount', ['type' => Table::TYPE_INTEGER, 'length' => 10]);
    }
}