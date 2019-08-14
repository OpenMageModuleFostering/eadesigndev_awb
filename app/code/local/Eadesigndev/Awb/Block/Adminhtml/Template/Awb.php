<?php

/**
 * Description of Template
 *
 * @author Ea Design
 */
class Eadesigndev_Awb_Block_Adminhtml_Template_Awb extends Mage_Adminhtml_Block_Template
{
    /*
     * Set the default grid view template
     */

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('eadesigndev/awb/list.phtml');
    }

    /*
     * Create blocks for grid and buttons and other stuff we need
     */

    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('awb/adminhtml_template_awb_grid', 'pdf.grid.template'));
        return parent::_prepareLayout();
    }



    /*
     * Add the header text using the helper
     */

    public function getHeaderText()
    {
        return Mage::helper('awb')->__('AWB Ne validate');
    }

}
