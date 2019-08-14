<?php

class Eadesigndev_Awb_Model_System_Tarifeafisate extends Eadesigndev_Awb_Model_System_Abstract
{
    public function toOptionArray()
    {
        return array(
            array('value' => '', 'label' => Mage::helper('awb')->__('Select')),
            array('value' => '1', 'label' => Mage::helper('awb')->__('Ramburs')),
            array('value' => '2', 'label' => Mage::helper('awb')->__('Cont colector')),
        );
    }
}