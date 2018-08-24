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


class Wisepops_Connect_Block_System_Configuration_Frontend_Button_Abstract extends Mage_Adminhtml_Block_System_Config_Form_Field {

    /**
     * @var string
     */
    const SIGNUP_URL = 'https://wisepops.com/try-it-out/plan/trial/duration/month?website=%s&utm_source=%s&utm_campaign=Magento&utm_medium=Plugin';
    /**
     * @var string
     */
    const SIGNIN_URL = 'https://wisepops.com/dashboard#magento?website=%s&utm_source=%s&utm_campaign=Magento&utm_medium=Plugin';

    /**
     * Returns the store URL for the buttons.
     * (Depending on the choosen scope on Magento Config Page).
     * @return string
     */
    public function getStoreUrl()
    {
        /* @var string */
        $scopeStoreCode     = Mage::getSingleton('adminhtml/config_data')->getStore();
        /* @var string */
        $scopeWebsiteCode   = Mage::getSingleton('adminhtml/config_data')->getWebsite();

        if (!empty($scopeStoreCode)) {
            /* @var $store Mage_Core_Model_Store */
            $store      = Mage::getModel('core/store')->load($scopeStoreCode, 'code');
        } else if (!empty($scopeWebsiteCode)) {
            /* @var $store Mage_Core_Model_Website */
            $website    = Mage::getModel('core/website')->load($scopeWebsiteCode, 'code');
            $store      = $website->getDefaultStore();
        } else {
            $store   = Mage::app()->getDefaultStoreView();
        }

        return $store->getBaseUrl();
    }

    /**
     * Returns the URL to redirect to when the user clicks on the Sign Up button
     * In the configuration page.
     * @return string
     */
    public function getSignUpUrl()
    {
        return sprintf(self::SIGNUP_URL, urlencode($this->getStoreUrl()), urlencode($this->getStoreUrl()));
    }

    /**
     * Returns The URL to redirect to when the user clicks on the Sign In button
     * In the configuration page.
     * @return string
     */
    public function getSignInUrl()
    {
        return sprintf(self::SIGNIN_URL, urlencode($this->getStoreUrl()), urlencode($this->getStoreUrl()));
    }

}