<?php

abstract class Eadesigndev_Awb_Model_System_Abstract
{
    public $helper;

    public function __construct()
    {
        $this->helper = Mage::helper('awb/urgent');
    }

    public function getHelper()
    {
        return $this->helper;
    }

    public function getError(){
        return array(
            array('value' => '', 'label' => Mage::helper('awb')->__('Trebuie sa ai un user si parola valide'))
        );
    }

}
