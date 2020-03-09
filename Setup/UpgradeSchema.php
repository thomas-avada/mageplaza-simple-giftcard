<?php
namespace Mageplaza\Giftcard\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\DB\Adapter\AdapterInterface;
use \Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        if(version_compare($context->getVersion(), '2.1.9', '<')) {
//            $setup->getConnection()->truncateTable('giftcard_code');
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
                        ['nullable' => false, 'default' => 0],
                        'Amount used'
                    )
                    ->addColumn(
                        'create_from',
                        Table::TYPE_TEXT,
                        50,
                        ['nullable' => false, 'default' => 'admin']
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
                $installer->getConnection()->addIndex(
                    $installer->getTable('giftcard_code'),
                    'unique code',
                    ['code'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                );
            }
            if (!$installer->tableExists('mp_giftcard_history')){
                $table = $installer->getConnection()
                    ->newTable(
                        $installer->getTable('giftcard_history')
                    )
                    ->addColumn(
                        'history_id',
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary'  => true,
                            'unsigned' => true
                        ],
                        'History ID'
                    )
                    ->addColumn(
                        'giftcard_id',
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'nullable' => false,
                            'unsigned' => true
                        ],
                        'Giftcard ID'
                    )
                    ->addColumn(
                        'customer_id',
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'nullable' => false,
                            'unsigned' => true
                        ],
                        'Customer ID'
                    )
                    ->addColumn(
                        'amount',
                        Table::TYPE_DECIMAL,
                        '12,4',
                        ['nullable' => false],
                        'Amount used'
                    )
                    ->addColumn(
                        'action',
                        Table::TYPE_TEXT,
                        100,
                        ['nullable' => false],
                        'Action by user'
                    )
                    ->addColumn(
                        'action_time',
                        Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                        'Action time'
                    )
                    ->setComment('Gifcard usage history table');
                ;
                $installer->getConnection()->createTable($table);
                $installer->getConnection()->addForeignKey(
                'giftcard_fk',
                'mp_giftcard_history',
                    'giftcard_id',
                    'mp_giftcard_code',
                    'giftcard_id'
                );
                $installer->getConnection()->addForeignKey(
                    'customer_fk',
                    'mp_giftcard_history',
                    'customer_id',
                    'mp_customer_entity',
                    'entity_id'
                );
            }
            if($installer->tableExists('mp_customer_entity')){
                $installer->getConnection()->addColumn(
                    'mp_customer_entity',
                    'giftcard_balance',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'size' => '12,4',
                        'nullable' => false,
                        'default' => 0,
                        'comment' => 'Giftcard Balance'
                    ]
                );
            }
            if($installer->tableExists('mp_giftcard_code')){
                $installer->getConnection()->addColumn(
                    'mp_giftcard_code',
                    'customer_id',
                    [
                        'type' => Table::TYPE_INTEGER,
                        'nullable' => false,
                        'comment' => 'Customer ID'
                    ]
                );
            }
//            $installer->getConnection()->addForeignKey(
//                'customer_fk',
//                'giftcard_code',
//                'customer_id',
//                'customer_entity',
//                'entity_id'
//            );
        }
        $installer->endSetup();
    }
}