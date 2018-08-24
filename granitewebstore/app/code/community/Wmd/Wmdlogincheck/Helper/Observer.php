<?php
/**
 * Wmd_Wmdlogincheck_Helper_Observer
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
class Wmd_Wmdlogincheck_Helper_Observer extends Mage_Core_Helper_Abstract
{
	  /**
	   * controller_action_layout_load_before    
     * Customer session check for isLoggedIn.
     * Ignore allowed paths and allowed customer account actions.
     * Redirect all other requests to customer account login page.           
     * 
     * @param object $observer 
     *
     * @return object
     */	 
     
    public function checkLogin($observer)
  	{
    		if (1 == Mage::getStoreConfig('wmdlogincheck/general/enable'))
        {
            $isLoggedIn = Mage::getSingleton( 'customer/session' )->isLoggedIn();
            
            $allowedPath = false;
            // set the customer account action names you want users to be able to access whitout being logged in
        		$allowedPathInfos = Mage::getStoreConfig('wmdlogincheck/pages/allowed');
            
            $allowedAction = false;
            // set the cms pages url keys you want users to be able to access whitout being logged in 
            $allowedActionNames = Mage::getStoreConfig('wmdlogincheck/actions/allowed');
            
            // make sure the account login page remains accessible
            $allowedActionNames .= ',\'customer_account_login\',\'customer_account_confirm\',\'customer_account_resetpassword\'';
            
            if (0 == Mage::getStoreConfig('wmdlogincheck/contacts/protect'))
            {
                $allowedPathInfos .= ',contacts'; 
                $allowedActionNames .= ',\'contacts_index_post\',\'contacts_index_index\'';   
            }
            
            // call event from observer
            $event = $observer->getEvent();
            // call action from event
        		$controller = $event->getAction();
            
            // get pathInfo of controller request
            $requestPathInfo = $controller->getRequest()->getPathInfo();
            
            // set allowedPath to true if allowedPathInfos contains the current PathInfo  
            if ($path = str_replace('/','', $requestPathInfo)) 
            {
                $allowedPath = is_int(strpos($allowedPathInfos, $path));
            }
            elseif ('/' == $requestPathInfo)
            {
                $allowedPath = is_int(strpos($allowedPathInfos, Mage::getStoreConfig('web/default/cms_home_page')));
            }
            
            // set allowedAction to true if allowedActionNames contains the current FullActionName
            $allowedAction = is_int(strpos($allowedActionNames, $controller->getFullActionName()));
            
         		// redirect to account login: if there is no login, 
            // request is not for an allowed cms page nor contains an allowed customer account action 
            if (!$isLoggedIn && !$allowedPath && !$allowedAction)		
        		{
                $controller->getResponse()->setRedirect(Mage::getUrl('customer/account/login'));
            }
        }                  
    		return $this;
  	}
	
    
	  /**
     * Check for isRegistrationAllowed.
     * customer_registration_is_allowed                
     * 
     * @param object $observer 
     *
     * @return object
     */	 
     
    public function checkIsRegistrationAllowed($observer)
    {
        if (!Mage::helper('wmdlogincheck')->canCreateAccount())
        {
            $observer->getResult()->setIsAllowed(false);
        }
        return $this;
    }
	
}