<?php

/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is licensed exclusively to Inovia Team.
 *
 * @copyright  Copyright (c) 2015 Inovia Team (http://www.inovia.fr)
 * @license      All rights reserved
 * @author       The Inovia Dev Team
 *
 * Used to display the button "Already registered" on the backend config page.
 */

class Wisepops_Connect_Block_System_Configuration_Frontend_Button_AlreadyRegistered extends Wisepops_Connect_Block_System_Configuration_Frontend_Button_Abstract {

    /* (non-PHPdoc)
     * @see Mage_Adminhtml_Block_System_Config_Form_Field::_getElementHtml()
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
        ->setType('button')
        ->setClass('scalable')
        ->setLabel($this->__('Already registered? Get your account number to start using WisePops with Magento.'))
        ->setOnClick("window.open('{$this->getSignInUrl()}', '_blank')")
        ->toHtml();

        return $html;
    }
}