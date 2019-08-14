<?php

$installer = $this;

$installer->getConnection()->addColumn($installer->getTable('awb/awb'), 'plan_tarifar', array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' =>255,
    'comment' => 'Plan Tarifar'
));


