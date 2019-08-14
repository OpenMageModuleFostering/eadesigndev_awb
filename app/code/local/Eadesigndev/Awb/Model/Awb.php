<?php

/**
 * Description of PdfGenerator
 *
 * @author Ea Design
 */
class Eadesigndev_Awb_Model_Awb extends Mage_Core_Model_Abstract
{

    const CARRIERFAN = 1;
    const CARRIERURGENT = 2;


    public function _construct()
    {
        $this->_init('awb/awb');
    }

    public function convertName($id)
    {
        $region = Mage::getModel('directory/region')->load($id);

        $name = $region->getName();

        $table = Mage::helper('catalog/product_url')->getConvertTable();
        $judet = strtr($name, $table);

        return $judet;
    }
}
