<?php
namespace Mageplaza\Giftcard\Setup;

use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\DB\Ddl\Table;
use \Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('mp_giftcard_code')) {
            $table = $installer->getConnection()
                ->newTable(
                    $installer->getTable('giftcard_code')
                )
                ->addColumn(
                    'giftcard_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ], //definition
                    'Giftcard ID'
                )
                ->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    20,
                    ['nullable => false'],
                    'Code'
                )
                ->addColumn(
                    'balance',
                    Table::TYPE_DECIMAL,
                    '12,4',
                    ['nullable' => false],
                    'Giftcard Ballance'
                )
                ->addColumn(
                    'amount_used',
                    Table::TYPE_DECIMAL,
                    '12,4',
                    ['nullable' => false],
                    'Amount used'
                )
                ->addColumn(
                    'create_from',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false]
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setComment('Giftcode Table');

            //Create the table
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}