<?php

/**
 * Description of General
 *
 * @author Ea Design
 */
class Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit_Tabs_General extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('general_tabs');
        $this->setDestElementId('form');
        $this->setTitle(Mage::helper('awb')->__('Item Information'));
    }

    /**
     * Add fields to form and create template info form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('awb_template');
        $form = new Varien_Data_Form();


        $fieldset = $form->addFieldset('general_fieldset', array(
            'legend' => Mage::helper('awb')->__('Template Information'),
            'class' => 'fieldset'
        ));

        if($model->getData('company')){
            $fieldset->addField('company', 'text', array(
                'name' => 'company',
                'label' => Mage::helper('awb')->__('Company'),
                'required' => false,
            ));
        }

        $fieldset->addField('destinatar', 'text', array(
            'name' => 'destinatar',
            'label' => Mage::helper('awb')->__('Destinatar'),
            'required' => true,
        ));

        if ($model->getId()) {
            $fieldset->addField('awb_id', 'hidden', array(
                'name' => 'awb_id',
            ));
        }
        if ($model->getData('order_id')) {
            $fieldset->addField('order_id', 'hidden', array(
                'name' => 'order_id',
            ));
        }

        $judetOptionArray = Mage::helper('awb')->getRegionByCountry('RO');

        if (is_array($judetOptionArray)) {
            $fieldset->addField('region_id', 'select', array(
                'label' => Mage::helper('awb')->__('Judet'),
                'title' => Mage::helper('awb')->__('Judet'),
                'name' => 'region_id',
                'options' => $judetOptionArray,
                'value' => 0,
                'required' => true,
            ));
        } else {
            $fieldset->addField('region_id', 'text', array(
                'label' => Mage::helper('awb')->__('Judet'),
                'title' => Mage::helper('awb')->__('Judet'),
                'name' => 'region_id',
                'required' => true,
            ));
        }

        $orasOtionsArray = Mage::helper('awb')->getCitiesByRegion('RO',$model->getData('region_id'));

        if (is_array($orasOtionsArray)) {
            $fieldset->addField('city', 'select', array(
                'label' => Mage::helper('awb')->__('Localitate'),
                'title' => Mage::helper('awb')->__('Localitate'),
                'name' => 'city',
                'options' => $orasOtionsArray,
                'value' => 0,
                'required' => true,
            ));
        } else {
            $fieldset->addField('city', 'text', array(
                'label' => Mage::helper('awb')->__('Localitate'),
                'title' => Mage::helper('awb')->__('Localitate'),
                'name' => 'city',
                'required' => true,
            ));
        }

        $fieldset->addField('street', 'text', array(
            'label' => Mage::helper('awb')->__('Strada'),
            'title' => Mage::helper('awb')->__('Strada'),
            'name' => 'street',
            'required' => true,
        ));

        $fieldset->addField('telephone', 'text', array(
            'label' => Mage::helper('awb')->__('Telefon'),
            'title' => Mage::helper('awb')->__('Telefon'),
            'name' => 'telephone',
            'required' => true,
        ));

        $fieldset->addField('customer_email', 'text', array(
            'label' => Mage::helper('awb')->__('E-mail'),
            'title' => Mage::helper('awb')->__('E-mail'),
            'name' => 'customer_email',
            'required' => true,
        ));

        $fieldset->addField('postcode', 'text', array(
            'label' => Mage::helper('awb')->__('Cod postal'),
            'title' => Mage::helper('awb')->__('Cod postal'),
            'name' => 'postcode',
            'required' => false,
        ));


//        echo '<pre>';
//        print_r($orasOtionsArray);
//        exit();

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }


}
