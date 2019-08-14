<?php

$installer = $this;

$installer->getConnection()->addColumn($installer->getTable('awb/awb'), 'valuare_comanda', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length'    => '12,2',
    'comment' => 'Valuare comanda'
));


