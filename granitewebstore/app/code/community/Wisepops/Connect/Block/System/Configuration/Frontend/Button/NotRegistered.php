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
 * Used to display the button "Not registered" on the configuration page.
 */

class Wisepops_Connect_Block_System_Configuration_Frontend_Button_NotRegistered extends Wisepops_Connect_Block_System_Configuration_Frontend_Button_Abstract {

    /* (non-PHPdoc)
     * @see Mage_Adminhtml_Block_System_Config_Form_Field::_getElementHtml()
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
        ->setType('button')
        ->setClass('scalable')
        ->setLabel($this->__('Not registered on WisePops? Click here to start your free trial!'))
        ->setOnClick("window.open('{$this->getSignUpUrl()}', '_blank')")
        ->toHtml();

        return $html;
    }
}