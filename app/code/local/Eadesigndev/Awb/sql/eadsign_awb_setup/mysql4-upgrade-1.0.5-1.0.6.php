<?php

$installer = $this;

$installer->getConnection()->addColumn($installer->getTable('awb/awb'), 'company', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' =>500,
    'comment' => 'Firma pentru livrare'
));


