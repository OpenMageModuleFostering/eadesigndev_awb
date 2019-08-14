<?php

/**
 * Created by IntelliJ IDEA.
 * User: eadesignpc
 * Date: 5/5/2015
 * Time: 10:16 AM
 */
class Eadesigndev_Awb_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getRegionByCountry($country)
    {
        $collection = Mage::getModel('directory/region')->getResourceCollection()
            ->addCountryFilter($country)
            ->load();

        $select = array();
        $select[''] = Mage::helper('awb')->__('Selecteaza');
        foreach ($collection as $judet) {
            $select[$judet->getId()] = $judet->getData('default_name');
        }

        return $select;
    }

    public function getCitiesByRegion($countryId, $regionId)
    {
        $cityCollection = Mage::getModel('awb/awbcity')->getCollection();

        $cityCollection
            ->addFieldToSelect('cityname')
            ->addFieldToFilter('country_id', $countryId)
            ->addFieldToFilter('region_id', $regionId);

        $select = array();
        $select[''] = Mage::helper('awb')->__('Selecteaza');
        foreach ($cityCollection as $oras) {
            $select[$oras->getData('cityname')] = $oras->getData('cityname');
        }

        return $select;
    }

    public function serviciiAsOtionArray()
    {
        $servicii = array(
            '' => 'Selecteaza',
            1 => 'Standard',
            2 => 'Cont colector'
        );

        return $servicii;
    }

    public function getRegionById($id)
    {

        $judet = Mage::getModel('awb/awb')->convertName($id);
        return $judet;
    }

    public function setTrackingCode($code, $awbModel)
    {
        $model = Mage::getModel('awb/awb')->load($awbModel->getData('awb_id'));
        $shipmentId = $model->getData('shippment_id');

        $shipment = Mage::getModel('sales/order_shipment')->load($shipmentId);


        $title = 'Urgent Curier';
        $carrier = 'Eadesigndev_urgent';


        $track = Mage::getModel('sales/order_shipment_track')
            ->setNumber($code)
            ->setCarrierCode($carrier)
            ->setTitle($title);

        $shipment->addTrack($track);

        try {
            $shipment->save();
        } catch (Mage_Core_Exception $e) {
            echo $e->getMessage();
        }

    }

    public function getPaymentCode($order)
    {
        if ($order instanceof Mage_Sales_Model_Order) {
            $payment = $order->getPayment();
            if (is_object($payment)) {
                $code = $payment->getMethodInstance()->getCode();
                return $code;
            }
        }
    }

    /**
     * Check if module is active
     * @return boolean
     */
    public function isActive()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/active');
    }

    /**
     * Get urgent user name
     * @return string
     */
    public function getUserName()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/username');
    }

    /**
     * Get urgent password
     * @return string
     */
    public function getPassword()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/password');
    }

    /**
     * Get punct de ridicare
     * @return string
     */
    public function getPctRidicare()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/punctridicare');
    }

    /**
     * Get plantarifar
     * @return string
     */
    public function getPlanTarifar()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/plantarifar');
    }

    /**
     * Get metoda de plata
     * @return string
     */
    public function getMetodaPlata()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/afisare');
    }

    /**
     * Get deschidere colet
     * @return boolean
     */
    public function getDeschidereColet()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/dechide');
    }

    /**
     * Get livrare sambata
     * @return boolean
     */
    public function getLivrareSambata()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/sambata');
    }

    /**
     * Get afisare metode
     * @return string
     */
    public function getAfisareMetode()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/pachet');
    }

    /**
     * Get asigurare
     * @return string
     */
    public function getAsigurare()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/asigurare');
    }

    /**
     * Get plata transport
     * @return string
     */
    public function getPlataTransport()
    {
        return Mage::getStoreConfig('awbopt/urgent_opt/platatransport');
    }


}