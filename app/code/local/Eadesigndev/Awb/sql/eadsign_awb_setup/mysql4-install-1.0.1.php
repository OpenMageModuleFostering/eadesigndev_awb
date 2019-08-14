<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mysql4-install-1
 *
 * @author Ea Design
 */
$installer = $this;

$installer->startSetup();

$installer->run("
 DROP TABLE IF EXISTS {$this->getTable('awb/awb')};
CREATE TABLE {$this->getTable('awb/awb')} (
 `awb_id` mediumint(8) unsigned NOT NULL auto_increment,
 `awb_number` varchar(255) NOT NULL default '0',
 `order_id` int(19) NOT NULL default '0',
 `shippment_id` int(19) NOT NULL default '0',
 `increment_order_id` varchar(255) NOT NULL default '0',
 `increment_shippment_id` varchar(255) NOT NULL default '0',
 `carrier_id` int(19) NOT NULL default '0',
 `awb_pickup_id` int(19) NOT NULL,
 `tip_seviciu` varchar(255) NOT NULL,
 `destinatar` varchar(255) NOT NULL,
 `country_id` varchar(255) NOT NULL,
 `region_id` int(19) NOT NULL,
 `city` varchar(255) NOT NULL,
 `street` varchar(255) NOT NULL,
 `telephone` varchar(255) NOT NULL,
 `customer_email` varchar(255) NOT NULL,
 `postcode` int(19) NOT NULL,
 `plicuri` int(19) NOT NULL,
 `colete` int(19) NOT NULL,
 `greutate` decimal(10,2) NOT NULL,
 `plata_ramburs` int(19) NOT NULL,
 `plata_expeditie` int(19) NOT NULL,
 `observatii` text NOT NULL,
 `ramburs_numerar` decimal(10,2) NOT NULL,
 `ramburs_cont_colector` decimal(10,2) NOT NULL,
 `continut` varchar(500) NOT NULL,
 `comentarii` varchar(500) NOT NULL,
 `status` int(19) NOT NULL default '0',
 `created_time` datetime NULL,
 `update_time` datetime NULL,
PRIMARY KEY (`awb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup();