<?php

/**
 * Created by IntelliJ IDEA.
 * User: eadesignpc
 * Date: 5/5/2015
 * Time: 10:16 AM
 */
class Eadesigndev_Awb_Helper_Urgent extends Mage_Core_Helper_Abstract
{
    private $ServiceUrl;
    private $Curl;
    private $_helper;

    public function __construct()
    {
        $this->_helper = Mage::helper('awb');

        $this->ServiceUrl = 'http://urgentcargus.cloudapp.net/IntegrationService.asmx';
        $this->Curl = curl_init();
        curl_setopt($this->Curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->Curl, CURLOPT_RETURNTRANSFER, true);
    }

    public function getHelper()
    {
        return $this->_helper;
    }

    private function getUrgentData($MethodName, $Parameters = null)
    {
        if ($Parameters != null) {
            $Parameters = json_encode($Parameters);
            curl_setopt($this->Curl, CURLOPT_POSTFIELDS, $Parameters);
        }
        curl_setopt($this->Curl, CURLOPT_URL, $this->ServiceUrl . '/' . $MethodName);
        curl_setopt($this->Curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($Parameters)));
        $data = json_decode(curl_exec($this->Curl));
        if (isset($data->d)) {
            if (strstr($MethodName, 'Print')) {
                return implode(array_map('chr', $data->d));
            } else {
                return $data->d;
            }
        } else {
            return array('error' => isset($data->Message) ? $data->Message : 'unknown');
        }
    }

    public function getToken($simple = false)
    {

        $credentials = array(
            'Username' => $this->getHelper()->getUserName(),
            'Password' => $this->getHelper()->getPassword(),
        );

        $token = $this->getUrgentData('LoginUser', $credentials);

        if (is_array($token)) {
            if (isset($token['error'])) {
                Mage::getSingleton('core/session')->addError($token['error']);
                return;
            }
        }

        if ($simple) {
            $fields = $token;
        } else {
            $fields = array(
                'Token' => $token
            );
        }
        return $fields;

    }

    public function getPunctRidicare()
    {
        if ($this->getToken()) {
            return $this->getUrgentData('GetPickupLocations', $this->getToken());
        }
        return false;
    }

    public function getPunctToOptonArray()
    {
        return $this->toOptionArray($this->getPunctRidicare(), 'LocationId', 'Name');
    }

    public function toOptionArray($array, $key, $value)
    {
        $return = array();
        foreach ($array as $element) {
            $return[$element->$key] = $element->$value;
        }
        return $return;
    }

    public function getPricePlans()
    {
        $planTarifar = $this->getUrgentData('GetPriceTables', $this->getToken());
        return $this->toOptionArray($planTarifar, 'PriceTableId', 'Name');
    }

    public function generateAwb($model)
    {

        $helper = Mage::helper('awb');

        $tipServiciu = $model->getData('tip_seviciu');
        if ($tipServiciu == 1) {
            $cashPayment = $model->getData('ramburs_cont_colector');
            $contColector = 0;
        } else {
            $cashPayment = 0;
            $contColector = $model->getData('ramburs_cont_colector');
        }


        $deschideColetVal = $model->getData('deschidere_colet');

        if ($deschideColetVal) {
            $deschideColet = true;
        } else {
            $deschideColet = false;
        }

        $livrareSambataVal = $model->getData('livrare_sambata');

        if ($livrareSambataVal) {
            $livrareSambata = true;
        } else {
            $livrareSambata = false;
        }

        $plataExpeditie = $model->getData('plata_expeditie');
        if (Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit_Tabs_Curier::LAEXPEDITOR == $plataExpeditie) {
            $plataExpeditieUrgent = 1;
        } else {
            $plataExpeditieUrgent = 2;
        }


        $token = $this->getToken();
        $stringToken = $token['Token'];

        $destinarar = $model->getData('destinatar');
        $company = $model->getData('company');
        $destinararName = $destinarar;
        if ($company) {
            $destinararName = $company;
        }

        $fields = array(
            'Token' => $stringToken,
            'Awb' => array(
                'Sender' => array(
                    'LocationId' => $model->getData('awb_pickup_id')
                ),
                'Recipient' => array(
                    'LocationId' => null,
                    'Name' => $destinararName,
                    'CountyId' => null,
                    'CountyName' => $helper->getRegionById($model->getData('region_id')),
                    'LocalityId' => null,
                    'LocalityName' => $model->getData('city'),
                    'Address' => $model->getData('street'),
                    'ContactPerson' => $destinarar,
                    'PhoneNumber' => $model->getData('telephone'),
                    'Email' => $model->getData('customer_email')
                ),
                'Parcels' => $model->getData('colete'),
                'Envelopes' => $model->getData('plicuri'),
                'TotalWeight' => round($model->getData('greutate')),
                'DeclaredValue' => $model->getData('valuare_comanda'),
                'CashRepayment' => $cashPayment,
                'BankRepayment' => $contColector,
                'OtherRepayment' => '',
                'OpenPackage' => $deschideColet,
                'PriceTableId' => $model->getData('plan_tarifar'),
                'ShipmentPayer' => $plataExpeditieUrgent,
                'SaturdayDelivery' => $livrareSambata,
                'Observations' => $model->getData('comentarii'),
                'PackageContent' => $model->getData('continut'),
                'CustomString' => ''
            ));


        $awb = $this->getUrgentData('NewAwb', $fields);

        return $awb;
    }

    public function getDataCity()
    {
        $token = $this->getToken(true);

        $fields = array(
            'Token' => $token,
            'CountyId' => null,
            'CountyName' => '',
            'CountryId' => null,
            'CountryName' => 'Romania'
        );

        $localities = $this->getUrgentData('GetLocalities', $fields);

        return $localities;
    }

    public function getDataCounty()
    {
        $token = $this->getToken(true);

        $fields = array(
            'Token' => $token,
            'CountryId' => null,
            'CountryName' => 'Romania'
        );

        return $this->getUrgentData('GetCounties', $fields);
    }

    public function getUrgent($method, $params = null)
    {
        return $this->getUrgentData($method, $params);
    }

    /**
     * Get check if module is connected and activated
     * @return bool
     */
    public function isConnected()
    {
        $helper = Mage::helper('awb');
        $isActive = $helper->isActive();
        $punct = $this->getPunctToOptonArray();

        if ($isActive && !empty($punct)) {
            return true;
        }

        return false;
    }

}