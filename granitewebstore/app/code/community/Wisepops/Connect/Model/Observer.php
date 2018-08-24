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
 */

class Wisepops_Connect_Model_Observer {


    /**
     * Verifies if the current config section is the wisepops config section
     * If it is, we add a Javascript file with a new validation method.
     *
     * It is only loaded when you are watching the Wisepops Connect configuration
     * Page on the Backend.
     *
     * @param Varien_Event_Observer $observer
     * @return Wisepops_Connect_Model_Observer
     */
    public function addJavascriptNeededFiles(Varien_Event_Observer $observer)
    {
        $section = Mage::getSingleton('adminhtml/config_data')->getSection();

        if ($section == Wisepops_Connect_Helper_Data::WISEPOPS_CONFIG_SECTION_NAME) {
            $headBlock = Mage::getSingleton('core/layout')->getBlock('head');
            if ($headBlock != null) {
                $headBlock->addJs('wisepops/validation.js');
            }
        }

        return $this;
    }

}