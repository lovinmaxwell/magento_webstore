<?php
/**
 * Wmd_Wmdlogincheck_Model_System_Config_Backend_Wmdlogincheck_Pages_Allowed  
 *
 * WMD Extensions 
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 *
 * @category  Wmd
 * @package   Wmd_Wmdlogincheck
 * @author    Dominik Wyss <info@wmdextensions.com>
 * @copyright 2014 Dominik Wyss | WMD Extensions  
 * @link      http://wmdextensions.com/
 * @license   http://wmdextensions.com/WMD-License-Community.txt 
*/?>
<?php
class Wmd_Wmdlogincheck_Model_System_Config_Backend_Wmdlogincheck_Pages_Allowed extends Mage_Core_Model_Config_Data
{
    public function _beforeSave()
    { 
        if ($this->isValueChanged() && $this->getValue()) {
            $cmsHomePage = Mage::getStoreConfig('web/default/cms_home_page');
            // throw error if the configurations cms_home_page is not in the array of allowed pages
            if (!in_array($cmsHomePage, $this->getValue())) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('wmdlogincheck')->__(
                        'System/Configuration/Web/Default Pages/CMS Home Page identifier is \'%s\'. '
                        . 'You should allow this page or set CMS Home Page to some page you allow here '
                        . 'to avoid this requests being forwarded to the Customer Login page.', $cmsHomePage)
                );
            }          
        }

        return $this;           
    }
}