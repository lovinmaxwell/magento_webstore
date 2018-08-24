<?php
class Magentothem_Onsaleslider_Block_Onsaleslider extends Mage_Catalog_Block_Product_Abstract
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getOnsaleslider()     
     { 
        if (!$this->hasData('onsaleslider')) {
            $this->setData('onsaleslider', Mage::registry('onsaleslider'));
        }
        return $this->getData('onsaleslider');
        
    }
	public function getProducts()
    {
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$_rootcatID = Mage::app()->getStore()->getRootCategoryId();
		$storeId    = Mage::app()->getStore()->getId();
		$cateids = $this->getConfig('catsid');
		$arr_catid = explode(",", $cateids);
		if($cateids) {
				$arr_productids = $this->getProductByCategory();
				$products = Mage::getResourceModel('catalog/product_collection')
				->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
				->addMinimalPrice()
				->addUrlRewrite()
				->addTaxPercents()			
				->addStoreFilter()
				->addIdFilter($arr_productids)// id product
				->addAttributeToFilter('special_to_date', array('date'=>true, 'from'=> $todayDate));
		}
		else {
		$products = Mage::getResourceModel('catalog/product_collection')
		->joinField('category_id','catalog/category_product','category_id','product_id=entity_id',null,'left')
				->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
				->addMinimalPrice()
				->addUrlRewrite()
				->addTaxPercents()			
				->addStoreFilter()
				->addAttributeToFilter('category_id', array('in' => $_rootcatID))
				->addAttributeToFilter('special_to_date', array('date'=>true, 'from'=> $todayDate));
		}
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
    }
	function getProductByCategory(){
		    $return = array(); 
		    $pids = array();
		    $catsid=$this->getConfig('catsid');
		    $products = Mage::getResourceModel ( 'catalog/product_collection' );
		     
		    foreach ($products->getItems() as $key => $_product){
			$arr_categoryids[$key] = $_product->getCategoryIds();
			
			if($catsid){    
			    if(stristr($catsid, ',') === FALSE) {
				$arr_catsid[$key] =  array(0 => $catsid);
			    }else{
				$arr_catsid[$key] = explode(",", $catsid);
			    }
			    
			    $return[$key] = $this->inArray($arr_catsid[$key], $arr_categoryids[$key]);
			}
		    }
		    
		    foreach ($return as $k => $v){ 
			if($v==1) $pids[] = $k;
		    }    
		    
		    return $pids;   
	}
	function inArray($source, $target) {
		for($i = 0; $i < sizeof ( $source ); $i ++) {
			if (in_array ( $source [$i], $target )) {
				return true;
			}
		}
	}
	
	public function getConfig($att) 
	{
		$config = Mage::getStoreConfig('onsaleslider');
		if (isset($config['onsaleslider_config']) ) {
			$value = $config['onsaleslider_config'][$att];
			return $value;
		} else {
			throw new Exception($att.' value not set');
		}
	}
	
	function cut_string_onsaleproductslider($string,$number){
		if(strlen($string) <= $number) {
			return $string;
		}
		else {	
			if(strpos($string," ",$number) > $number){
				$new_space = strpos($string," ",$number);
				$new_string = substr($string,0,$new_space)."..";
				return $new_string;
			}
			$new_string = substr($string,0,$number)."..";
			return $new_string;
		}
	}
}