<?php

/**
 * Description of Grid
 *
 * @author Ea Design
 */
class Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /*
     * set the default values for the grid system
     */

    protected function _construct()
    {
        $this->setEmptyText(Mage::helper('awb')->__('Nu sunt awb la validare'));
        $this->setId('awb');
        $this->setUseAjax(false);
        $this->setSaveParametersInSession(true);
    }

    /*
     * We set the collection to use
     */

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('awb/awb')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /*
     * Add the columns in the grid view
     */

    protected function _prepareColumns()
    {
        $this->addColumn('awb_id', array(
                'header' => Mage::helper('awb')->__('ID'),
                'index' => 'awb_id',
                'width' => '10px'
            )
        );

        $this->addColumn('created_time', array(
            'header' => Mage::helper('awb')->__('Created Time'),
            'align' => 'left',
            'index' => 'created_time',
            'type' => 'date',
        ));

        $this->addColumn('increment_order_id', array(
            'header' => Mage::helper('awb')->__('Id comanda'),
            'index' => 'increment_order_id'
        ));

        $this->addColumn('carrier_id', array(
            'header' => Mage::helper('awb')->__('Courier'),
            'index' => 'carrier_id',
            'type' => 'options',
            'options' => array(
                Eadesigndev_Awb_Model_Awb::CARRIERURGENT => 'Urgent Curier',
            ),
        ));

        $this->addColumn('awb_number', array(
            'header' => Mage::helper('awb')->__('Numar awb'),
            'index' => 'awb_number'
        ));

        $this->addColumn('awb_pickup_id', array(
            'header' => Mage::helper('awb')->__('Punct ridicare'),
            'index' => 'awb_pickup_id',

        ));

        $this->addColumn('destinatar', array(
            'header' => Mage::helper('awb')->__('Destinatar'),
            'index' => 'destinatar'
        ));

        $this->addColumn('dest_localitate', array(
            'header' => Mage::helper('awb')->__('Localitate'),
            'index' => 'dest_localitate'
        ));

        $this->addColumn('colete', array(
            'header' => Mage::helper('awb')->__('Colete'),
            'index' => 'colete'
        ));

        $this->addColumn('plata_expeditie', array(
            'header' => Mage::helper('awb')->__('Courier'),
            'index' => 'plata_expeditie',
            'type' => 'options',
            'options' => array(
                Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit_Tabs_Curier::LADESTINATIE => 'Destinatar',
                Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit_Tabs_Curier::LAEXPEDITOR => 'Expeditor',
            ),
        ));

        $this->addColumn('valuare_comanda', array(
            'header' => Mage::helper('awb')->__('Valuare comanda'),
            'index' => 'valuare_comanda'
        ));

        $this->addColumn('ramburs_cont_colector', array(
            'header' => Mage::helper('awb')->__('Cont colector'),
            'index' => 'ramburs_cont_colector'
        ));

        $this->addColumn('plata_expeditie', array(
            'header' => Mage::helper('awb')->__('Plata Expeditie'),
            'index' => 'plata_expeditie',
            'type' => 'options',
            'options' => array(
                Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit_Tabs_Curier::LADESTINATIE => Mage::helper('awb')->__('La destinatie'),
                Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit_Tabs_Curier::LAEXPEDITOR => Mage::helper('awb')->__('La expeditor'),
            )
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('awb')->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('awb')->__('Nou'),
                1 => Mage::helper('awb')->__('Aprobat'),
            )
        ));

        $this->addColumn('action',
            array(
                'header' => Mage::helper('sales')->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('sales')->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'id',
                        'data-column' => 'action',
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
            ));

        return $this;
    }

    /*
     * We get the row to get action to edit the current id of the template
     */

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}