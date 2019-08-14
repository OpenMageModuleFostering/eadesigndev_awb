<?php

/**
 * Description of General
 *
 * @author Ea Design
 */
class Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit_Tabs_Curier extends Mage_Adminhtml_Block_Widget_Form
{

    const LADESTINATIE = 1;
    const LAEXPEDITOR = 2;

    private $isUrgent = false;

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


        if ($model->getData('carrier_id') == Eadesigndev_Awb_Model_Awb::CARRIERURGENT) {
            $this->isUrgent = true;
        }


        $fieldset = $form->addFieldset('general1_fieldset', array(
            'legend' => Mage::helper('awb')->__('Template Information'),
            'class' => 'fieldset'
        ));


        $fieldset->addField('carrier_id', 'select', array(
            'label' => Mage::helper('awb')->__('Curier'),
            'title' => Mage::helper('awb')->__('Curier'),
            'name' => 'carrier_id',
            'options' => array(
                Eadesigndev_Awb_Model_Awb::CARRIERURGENT => 'Urgent Curier',
            ),
            'required' => true,
            'required' => true,
            'readonly' => true,
            'class' => 'disabled',
            'disabled' => true,
            'permission' => 'readonly',
        ));

        $fieldset->addField('tip_seviciu', 'select', array(
            'label' => Mage::helper('awb')->__('Metoda plata'),
            'title' => Mage::helper('awb')->__('Metoda plata'),
            'name' => 'tip_seviciu',
            'options' => Mage::helper('awb')->serviciiAsOtionArray(),
            'required' => true,
        ));


        if ($this->isUrgent) {

            $planTarifar[''] =  Mage::helper('awb')->__('Selecteaza');
            $planTarifar  = Mage::helper('awb/urgent')->getPricePlans();

            $fieldset->addField('plan_tarifar', 'select', array(
                'label' => Mage::helper('awb')->__('Plan tarifar'),
                'title' => Mage::helper('awb')->__('Plan tarifar'),
                'name' => 'plan_tarifar',
                'options' => $planTarifar,
                'required' => true,
            ));
            $punctRidicare1 =  array(''=>Mage::helper('awb')->__('Selecteaza'));
            $punctRidicare = $punctRidicare1+Mage::helper('awb/urgent')->getPunctToOptonArray();

        }

        $fieldset->addField('awb_pickup_id', 'select', array(
            'label' => Mage::helper('awb')->__('Punct de ridicare'),
            'title' => Mage::helper('awb')->__('Punct de ridicare'),
            'name' => 'awb_pickup_id',
            'options' => $punctRidicare,
            'required' => true,
        ));

        $fieldset->addField('plata_expeditie', 'select', array(
            'label' => Mage::helper('awb')->__('Plata expeditie'),
            'title' => Mage::helper('awb')->__('Plata expeditie'),
            'name' => 'plata_expeditie',
            'options' => array(
                '' => Mage::helper('awb')->__('Selecteaza'),
                self::LADESTINATIE => 'Destinatar',
                self::LAEXPEDITOR => 'Expeditor',
            ),
            'required' => true,
        ));

        $fieldset->addField('greutate', 'text', array(
            'name' => 'greutate',
            'label' => Mage::helper('awb')->__('Greutate'),
            'required' => true,
        ));

        $fieldset->addField('colete', 'text', array(
            'name' => 'colete',
            'label' => Mage::helper('awb')->__('Colete'),
            'required' => false,
        ));

        $fieldset->addField('plicuri', 'text', array(
            'name' => 'plicuri',
            'label' => Mage::helper('awb')->__('Plicuri'),
            'required' => false,
        ));

        $fieldset->addField('valuare_comanda', 'text', array(
            'name' => 'valuare_comanda',
            'label' => Mage::helper('awb')->__('Valoare asigurare comanda'),
            'required' => true,
        ));

        $fieldset->addField('ramburs_cont_colector', 'text', array(
            'name' => 'ramburs_cont_colector',
            'label' => Mage::helper('awb')->__('Valoare ramburs'),
            'required' => true,
        ));

        $fieldset->addField('continut', 'textarea', array(
            'name' => 'continut',
            'label' => Mage::helper('awb')->__('Continut'),
            'required' => false,
        ));

        $fieldset->addField('livrare_sambata', 'select', array(
            'label' => Mage::helper('awb')->__('Livrare sambata'),
            'title' => Mage::helper('awb')->__('Livrare sambata'),
            'name' => 'livrare_sambata',
            'options' => array(
                '' => Mage::helper('awb')->__('Selecteaza'),
                0 => 'Nu',
                1 => 'Da',
            ),
            'required' => true,
        ));


        $fieldset->addField('deschidere_colet', 'select', array(
            'label' => Mage::helper('awb')->__('Deschidere colet'),
            'title' => Mage::helper('awb')->__('Deschidere colet'),
            'name' => 'deschidere_colet',
            'options' => array(
                '' => Mage::helper('awb')->__('Selecteaza'),
                0 => 'Nu',
                1 => 'Da',
            ),
            'required' => true,
        ));

        $fieldset->addField('comentarii', 'textarea', array(
            'name' => 'comentarii',
            'label' => Mage::helper('awb')->__('Comentarii'),
            'required' => false,
        ));



        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }


}
