<?php

/**
 * Description of Edit
 *
 * @author Ea Design
 */
class Eadesigndev_Awb_Block_Adminhtml_Template_Awb_Edit extends Mage_Adminhtml_Block_Widget
{

    /**
     * Initialize
     */
    protected function _construct()
    {
        $this->setTemplate('eadesigndev/awb/edit/edit.phtml');
        parent::_construct();
    }

    protected function getCurrentModel()
    {
        $model = mage::registry('awb_template');
        if ($model) {
            return $model;
        }
        return false;
    }

    /**
     * Preparing the layout
     */
    protected function _prepareLayout()
    {
        $disable = false;
        if ($this->getCurrentModel()->getData('status')) {
            $disable = true;
        }

        $this->setChild('back_button', $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(
                array(
                    'label' => Mage::helper('awb')->__('Back'),
                    'onclick' => "window.location.href = '" . $this->getUrl('*/*') . "'",
                    'class' => 'back',
                )
            )
        );

        $this->setChild('reset_button', $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(
                array(
                    'label' => Mage::helper('awb')->__('Reset'),
                    'onclick' => 'window.location.href = window.location.href',
                    'disabled' => $disable
                )
            )
        );

        $this->setChild('approve_button', $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(
                array(
                    'label' => Mage::helper('awb')->__('Aproba AWB'),
                    'onclick' => 'templateControl.approveTemplate();',
                    'class' => 'save',
                    'disabled' => $disable
                )
            )
        );

        $this->setChild('save_button', $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(
                array(
                    'label' => Mage::helper('awb')->__('Salveaza AWB'),
                    'onclick' => 'templateControl.save();',
                    'class' => 'save',
                    'disabled' => $disable
                )
            )
        );
        $this->setChild('save_button_continue', $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(
                array(
                    'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                    'onclick' => 'templateControl.saveandcontinue();',
                    'class' => 'save',
                    'disabled' => $disable
                )
            )
        );

        return parent::_prepareLayout();
    }

    /**
     * Back button return to the etension root
     */
    public function getBackButtonHtml()
    {
        return $this->getChildHtml('back_button');
    }

    /**
     * Reset template - will rest all fields
     */
    public function getResetButtonHtml()
    {
        return $this->getChildHtml('reset_button');
    }

    /**
     * Save current template button
     */
    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }

    /**
     * Save current template button
     */
    public function getSaveContinueButtonHtml()
    {
        return $this->getChildHtml('save_button_continue');
    }

    /**
     * Not sure we will use this one
     */
    public function getPreviewButtonHtml()
    {
        return $this->getChildHtml('preview_button');
    }

    /**
     * Detele button
     */
    public function getApproveButtonHtml()
    {
        return $this->getChildHtml('approve_button');
    }


    /**
     * Return header text for form
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('awb')->__('Edit AWB');
    }

    /**
     * Return form block HTML
     *
     * @return string
     */
    public function getFormHtml()
    {
        return $this->getChildHtml('form');
    }

    /**
     * Return action url for form
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current' => true));
    }

    public function getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current' => true,
            'back' => 'edit',
        ));
    }

    /**
     * Return preview action url for form
     *
     * @return string
     */
    public function getPreviewUrl()
    {
        return $this->getUrl('*/*/preview');
    }

    /**
     * Return delete url for customer group
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array('_current' => true));
    }

    public function getApproveUrl()
    {
        return $this->getUrl('*/*/save',
            array('_current' => true,
                'approve' => 'edit',
                'back' => 'edit'
            )
        );
    }

    public function getLocaleOptions()
    {
        return Mage::app()->getLocale()->getOptionLocales();
    }

    public function getCurrentLocale()
    {
        return Mage::app()->getLocale()->getLocaleCode();
    }

}
