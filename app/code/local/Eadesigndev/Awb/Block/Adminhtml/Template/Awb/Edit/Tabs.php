<?php

/**
 * Description of Tabs
 *
 * @author Ea Design
 */
class Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Initializa the tab system
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('awb_tabs');
        $this->setDestElementId('awb_template_new_form');
        $this->setTitle(Mage::helper('awb')->__('Date AWB'));
    }

    /**
     * Generate the teab system to send tot he template.
     */
    public function _beforeToHtml()
    {
        $this->addTab('general_section', array(
            'label' => Mage::helper('awb')->__('Adresa'),
            'title' => Mage::helper('awb')->__('Date AWB'),
            'content' => $this->getLayout()->createBlock('awb/adminhtml_template_awb_edit_tabs_general')->toHtml(),
        ));

        $this->addTab('main_section', array(
            'label' => Mage::helper('awb')->__('Curier'),
            'title' => Mage::helper('awb')->__('Curier'),
            'content' => $this->getLayout()->createBlock('awb/adminhtml_template_awb_edit_tabs_curier')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}

