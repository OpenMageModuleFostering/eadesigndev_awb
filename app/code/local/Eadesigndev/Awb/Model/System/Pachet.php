<?php

class Eadesigndev_Awb_Model_System_Pachet extends Eadesigndev_Awb_Model_System_Abstract
{
    public function toOptionArray()
    {
        return array(
            array('value' => '0', 'label' => Mage::helper('awb')->__('Colet')),
            array('value' => '1', 'label' => Mage::helper('awb')->__('Plic')),
        );
    }
}