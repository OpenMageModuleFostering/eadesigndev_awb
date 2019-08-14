<?php

$installer = $this;

$installer->getConnection()->addColumn($installer->getTable('awb/awb'), 'livrare_sambata', array(
    'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
    'unsigned' => true,
    'nullable' => false,
    'default' => '0',
    'comment' => 'Dechide packet'
));

$installer->getConnection()->addColumn($installer->getTable('awb/awb'), 'deschidere_colet', array(
    'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
    'unsigned' => true,
    'nullable' => false,
    'default' => '0',
    'comment' => 'The store id'
));
