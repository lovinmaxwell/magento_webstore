<?php
/**
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
class Wmd_Wmdlogincheck_Model_System_Config_Source_Customer_Logincheck_Actions
{
    /**
     * Actions
     * @var array
     */		
    protected $_options;
	
    /**
     * Return the avaiable customer account actions
     * 
     * @param boolean $isMultiselect if Multiselect for the order status selection is allowed 
     *
     * @return array
     */	      
	  public function toOptionArray($isMultiselect=false)
    {		
		    if (!$this->_options) { 		    
            $this->_options = array(
                array('value' => '', 'label' => Mage::helper('wmdlogincheck')->__('Disable All')),
                array('value' => '/customer_account_create/', 'label' => Mage::helper('wmdlogincheck')->__('Customer Account Create')),
                array('value' => '/customer_account_forgotpassword/', 'label' => Mage::helper('wmdlogincheck')->__('Customer Account Forgot Password')),
//                 array('value' => '/customer_account_confirmation/', 'label' => Mage::helper('wmdlogincheck')->__('Customer Account Confirmation')),
            );
            return $this->_options;
        }		
    }
}