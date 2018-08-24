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
 * Frontend block used to display the wisepops script.
 */

class Wisepops_Connect_Block_Wisepops extends Mage_Core_Block_Template {

    /**
     * Returns the wisepops id configured in the backend
     * @return string|NULL
     */
    public function getWisepopsUserId()
    {
        return Mage::getStoreConfig(
            Wisepops_Connect_Helper_Data::XML_PATH_CONFIG_WISEPOPS_USER_ID,
            Mage::app()->getStore()
        );
    }

    /**
     * Verifies if the wisepops should be displayed or not. (configured in the Backend configuration section).
     * @return boolean
     */
    public function isWisepopsActivated()
    {
        return (bool)Mage::getStoreConfig(
            Wisepops_Connect_Helper_Data::XML_PATH_CONFIG_WISEPOPS_ACTIVATED,
            Mage::app()->getStore()
        );
    }

}