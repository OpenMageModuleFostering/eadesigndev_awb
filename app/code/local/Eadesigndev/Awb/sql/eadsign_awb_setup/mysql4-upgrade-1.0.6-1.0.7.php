<?php

$installer = $this;

$installer->run("
CREATE TABLE IF NOT EXISTS {$this->getTable('awb/awbcity')} (
 `city_id` mediumint(8) unsigned NOT NULL auto_increment,
 `country_id` varchar(4) NOT NULL default '0',
 `region_id` varchar(4) NOT NULL default '0',
 `cityname` varchar(255) default NULL,
 PRIMARY KEY (`city_id`),
 KEY `FK_CITY_REGION` (`region_id`))
 ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Region Cities';
 ");


