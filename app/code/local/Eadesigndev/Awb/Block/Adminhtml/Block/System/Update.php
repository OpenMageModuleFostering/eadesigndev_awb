<?php

class Eadesigndev_Awb_Block_Adminhtml_Block_System_Update extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $helper = Mage::helper('awb/urgent');
        $isConnected = $helper->isConnected();

        if (!$isConnected) {
            return;
        }

        $this->setElement($element);
        $url = Mage::helper('adminhtml')->getUrl('adminhtml/awb/update');

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setClass('scalable')
            ->setLabel('Update lista orase!')
            ->setOnClick("setLocation('$url')")
            ->toHtml();

        return $html;
    }
}