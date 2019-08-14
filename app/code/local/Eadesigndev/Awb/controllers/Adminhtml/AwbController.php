<?php

/**
 *
 * @author Ea Design
 */
class  Eadesigndev_Awb_Adminhtml_AwbController extends Mage_Adminhtml_Controller_Action
{
    /**
     * The index action on main extension pannel
     *
     */
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('AWB In asteptare'));

        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }

        $this->loadLayout();
        $this->_setActiveMenu('adminhtml/index');
        $this->_addBreadcrumb(Mage::helper('awb')->__('AWB Ne validate'), Mage::helper('awb')->__('AWB Ne validate'));

        $listBlock = $this->getLayout()->createBlock('awb/adminhtml_template_awb', 'awb-list');
        $this->_addContent($listBlock);

        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock('awb/adminhtml_template_awb')->toHtml());
    }

    /*
     * Edit the awb template
     */

    public function editAction()
    {
        $this->loadLayout();

        $this->_initTemplate('id');

        $this->_setActiveMenu('adminhtml/awb');
        $this->_title($this->__('AWB'))->_title($this->__('Edit AWB'));

        $this->_addBreadcrumb(Mage::helper('awb')
            ->__('Edit AWB'), Mage::helper('awb')
            ->__('Edit AWB'));
        /*
         * The edit form!!!
         */
        $this->_addContent(
            $this->getLayout()
                ->createBlock('awb/adminhtml_template_awb_edit', 'edit_form')
        );
        $this->_addLeft(
            $this->getLayout()
                ->createBlock('awb/adminhtml_template_awb_edit_tabs', 'awb_edit')
        );


        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent

        if ($data = $this->getRequest()->getPost()) {

            $data = $this->_filterPostData($data);
            //init model and set data
            $model = $this->_initTemplate('id');

            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
            }

            $model->setData($data);

            if ($id = $this->getRequest()->getParam('id')) {
                $model->setData('update_time', now());
            } else {
                $model->setData('created_time', now());
                $model->setData('update_time', now());
            }

            if ($this->getRequest()->getParam('approve')) {

                $modelLoad = Mage::getModel('awb/awb')->load($model->getData('awb_id'));

                if ($modelLoad->getData('carrier_id') == Eadesigndev_Awb_Model_Awb::CARRIERFAN) {
                    $code = Mage::helper('awb/csvgen')->generateCsvList($this->getRequest()->getParam('awb_id'));
                    if (is_array($code)) {
                        $codeLine = implode(',', $code);
                        Mage::getSingleton('adminhtml/session')->addError(
                            Mage::helper('cms')->__($codeLine));
                        $this->_redirect('*/*/*');
                        return;
                    }
                }


                if ($modelLoad->getData('carrier_id') == Eadesigndev_Awb_Model_Awb::CARRIERURGENT) {
                    $urgentHelper = Mage::helper('awb/urgent');
                    $code = $urgentHelper->generateAwb($model);
                    if (is_array($code)) {
                        $codeLine = implode(',', $code);
                        Mage::getSingleton('adminhtml/session')->addError(
                            Mage::helper('cms')->__($codeLine));
                        $this->_redirect('*/*/*');
                        return;
                    }


                }
                $awbHelper = Mage::helper('awb');

                $model->setData('awb_number', $code);
                $awbHelper->setTrackingCode($code, $model);

                $model->setData('status', 1);
            }

            Mage::dispatchEvent('awb_prepare_save', array('awb' => $model, 'request' => $this->getRequest()));
            try {


                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('cms')->__('Awb salvat.'));

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back') || $this->getRequest()->getParam('approve')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e, Mage::helper('awb')->__('An error occurred while saving the template.') . $e->getMessage());
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('awb_id' => $this->getRequest()->getParam('awb_id')));
            return;
        }
        $this->_redirect('*/*/');
    }

    /**
     * Generate awb  action
     */
    public function generateAction()
    {
        // check if data sent
        $helper = Mage::app()->getHelper('awb');

        $model = $this->_initTemplate('id');

        $model->setData('created_time', now());
        $model->setData('update_time', now());

        $model->setData('status', 0);

        $orderId = $this->getRequest()->getParam('order_id');
        if ($orderId) {
            $model->setData('order_id', $orderId);

            $order = Mage::getModel('sales/order')->load($orderId);
            $model->setData('increment_order_id', $order->getIncrementId());


            if ($company = $order->getShippingAddress()->getData('company')) {
                $model->setData('company', $company);
            }

            $fName = $order->getShippingAddress()->getData('firstname');
            $lName = $order->getShippingAddress()->getData('lastname');

            $name = $fName . ' ' . $lName;

            $customerName = $name;
            $model->setData('destinatar', $customerName);

            $customerDestCountry = $order->getShippingAddress()->getData('country_id');
            $model->setData('country_id', $customerDestCountry);

            $customerDestJudetId = $order->getShippingAddress()->getData('region_id');
            $model->setData('region_id', $customerDestJudetId);

            $customerDestLocalitate = $order->getShippingAddress()->getData('city');
            $model->setData('city', $customerDestLocalitate);

            $customerDestStrada = $order->getShippingAddress()->getData('street');
            $model->setData('street', $customerDestStrada);

            $customerPhone = $order->getShippingAddress()->getData('telephone');
            $model->setData('telephone', $customerPhone);

            $customerEmail = $order->getData('customer_email');
            $model->setData('customer_email', $customerEmail);

            $customerDestZip = $order->getData('postcode');
            if (is_numeric($customerDestZip)) {
                $model->setData('postcode', $customerDestZip);
            }

            $customerCarrierId = $this->getRequest()->getParam('carrier_id');
            $model->setData('carrier_id', $customerCarrierId);



            $planTarifar = $helper->getPlanTarifar();
            $model->setData('plan_tarifar', $planTarifar);

            $metodaPlata = $helper->getMetodaPlata();
            $model->setData('tip_seviciu', $metodaPlata);

            $pctRidicare = $helper->getPctRidicare();
            $model->setData('awb_pickup_id', $pctRidicare );

            $deschidereColet = $helper->getDeschidereColet();
            $model->setData('deschidere_colet',$deschidereColet);

            $livrareSambata = $helper->getLivrareSambata();
            $model->setData('livrare_sambata',$livrareSambata);



            $shipmentId = $this->getRequest()->getParam('shippment_id');
            if ($shipmentId) {
                $model->setData('shippment_id', $shipmentId);
                $shippment = Mage::getModel('sales/order_shipment')->load($shipmentId);
                $model->setData('increment_shippment_id', $shippment->getIncrementId());
                $items = $shippment->getItemsCollection();

                $intemsNames = array();
                $colete = '';
                $wheight = '';
                foreach ($items as $item) {
                    $intemsNames[] = $item->getData('name');
                    $colete += $item->getData('qty');
                    $wheight += $item->getData('qty') * $item->getData('weight');
                }

                $finalNames = implode(',', $intemsNames);
                $finalWhight = round($wheight, 0);
            }

            $plataTransport=$helper->getPlataTransport();
            $model->setData('plata_expeditie',$plataTransport);

            $model->setData('greutate', $finalWhight);
            $afisareMetode = $helper->getAfisareMetode();

            if($afisareMetode){
                $model->setData('colete', 0);
                $model->setData('plicuri', $colete);
            }else{
                $model->setData('colete', $colete);
                $model->setData('plicuri', 0);
            }


            $total = round($order->getData('grand_total'), 2);

            $asigurare = $helper->getAsigurare();
            if($asigurare){
                $model->setData('valuare_comanda',$total);
            }else{
                $model->setData('valuare_comanda',0);
            }


            if ($helper->getPaymentCode($order) == 'checkmo') {
                $model->setData('ramburs_cont_colector', $total);
            } else {
                $model->setData('tip_seviciu', 'Standard');
                $model->setData('ramburs_cont_colector', 0);
            }

            $model->setData('continut', $finalNames);

            try {

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('cms')->__('Awb generat.'));

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                $this->_redirect('*/*/edit/', array('id' => $model->getId()));
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e, Mage::helper('awb')->__('An error occurred while saving the template.'));
            }
        }
    }


    /*
     * Load the awb template for processing
     *
     * @param string $pdfFieldNameId;
     * @return the model object with the loaded id
     */

    protected function _initTemplate($fieldNameId = 'id')
    {
        $this->_title($this->__('System'))->_title($this->__('AWB'));
        $id = (int)$this->getRequest()->getParam($fieldNameId);
        $model = Mage::getModel('awb/awb');
        if ($id) {
            $model->load($id);
        }
        if (!Mage::registry('awb_template')) {
            Mage::register('awb_template', $model);
        }
        if (!Mage::registry('current_awb_template')) {
            Mage::register('current_awb_template', $model);
        }

        return $model;
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('custom_theme_from', 'custom_theme_to'));
        return $data;
    }

    public function updateAction()
    {
        Mage::helper('awb/update')->getUrgentCollection();
        $this->_redirectReferer();
    }

    public function settingsAction()
    {

        $url = Mage::helper('adminhtml')->getUrl('adminhtml/system_config/edit/section/awbopt');
        Mage::app()->getResponse()->setRedirect($url);
    }

    public function citiesAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return;
        }

        $cityId = (int)$this->getRequest()->getParam('city_id');
        $countryId = $this->getRequest()->getParam('country_id');

        if (!$cityId || !$countryId) {
            return;
        }

        echo Mage::helper('awb/city')->getCities($countryId, $cityId);

        return;
    }
}
