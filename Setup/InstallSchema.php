<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Queue\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var SchemaSetupInterface
     */
    private $setup;
    
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->setup = $setup;

        $setup->startSetup();
        
        $this->createTables();

        $setup->endSetup();
    }
    
    
    private function createTables()
    {
        $setup = $this->setup;

        $table = $setup->getConnection()->newTable(
            $this->setup->getTable('cotya_queue')
        )
            ->addColumn('id', Table::TYPE_BIGINT, null, array(
                'identity' => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ))
            ->addColumn('type', Table::TYPE_TEXT, 255, array(
                'nullable'  => false,
            ))
            ->addColumn('value', Table::TYPE_TEXT, 255, array(
                'nullable'  => false,
            ));
        $setup->getConnection()->createTable($table);
    }
}
