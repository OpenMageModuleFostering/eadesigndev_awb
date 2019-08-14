<?php

/**
 * Created by IntelliJ IDEA.
 * User: eadesignpc
 * Date: 7/14/2015
 * Time: 2:19 PM
 */
class Eadesigndev_Awb_Helper_City
{
    /**
     * Get city
     * @return string
     */
    public function getCity()
    {
        $cities = Mage::helper('awb/urgent')->getDataCity();

        return $cities;
    }

    /**
     * Get country
     * @return string
     */
    public function getCounty()
    {
        $counties = Mage::helper('awb/urgent')->getDataCounty();

        return $counties;
    }

    public function getCities($countryId, $regionId)
    {
        $cityCollection = Mage::getModel('awb/awbcity')->getCollection();
        $cityCollection->addFieldToSelect('cityname')
            ->addFieldToFilter('country_id', $countryId)
            ->addFieldToFilter('region_id', $regionId);

        $jsonData = Mage::helper('core')->jsonEncode($cityCollection->getData());

        return $jsonData;
    }
}