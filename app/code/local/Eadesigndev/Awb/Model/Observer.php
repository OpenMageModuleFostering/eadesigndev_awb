<?php

/**
 * Created by IntelliJ IDEA.
 * User: eadesignpc
 * Date: 6/23/2015
 * Time: 11:56 AM
 */
class Eadesigndev_Awb_Model_Observer
{
    public function addButtonShip($observer)
    {

        $helper = Mage::helper('awb/urgent');
        $isConnected = $helper->isConnected();

        if (!$isConnected){
            return $this;
        }

        $container = $observer->getBlock();

        if (null !== $container && $container->getType() == 'adminhtml/sales_order_shipment_view') {

            $dataUrgent = array(
                'label' => 'Genereaza awb Urgent',
                'class' => 'awb-button',
                'onclick' => 'setLocation(\' ' . Mage::helper("adminhtml")->getUrl("adminhtml/awb/generate",
                        array(
                            'shippment_id' => $container->getShipment()->getId(),
                            'order_id' => $container->getShipment()->getOrderId(),
                            'carrier_id'=>Eadesigndev_Awb_Model_Awb::CARRIERURGENT
                        )) . '\')',
            );
            $container->addButton('my_button_identifier1', $dataUrgent);
        }

        return $this;
    }
}