<?php
class Magentothem_Featuredproduct_Block_Featuredproduct extends Mage_Catalog_Block_Product_Abstract
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getFeaturedproduct()     
    { 
        if (!$this->hasData('featuredproduct')) {
            $this->setData('featuredproduct', Mage::registry('featuredproduct'));
        }
        return $this->getData('featuredproduct');
    }
	public function getProducts()
    {
    	$storeId    = Mage::app()->getStore()->getId();
	$cateids = $this->getConfig('catsid');
	if($cateids != null)
    	    {
		$arr_productids = $this->getProductByCategory();
		$products = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
			->addStoreFilter()
			->addIdFilter($arr_productids)// id product
			->setOrder($this->getConfig('sort'),$this->getConfig('direction'))
			//->addAttributeToFilter("featured", 1);	
			->addFieldToFilter(array(
			array('attribute'=>'featured','eq'=>'1'),
			));	
			
	    } else {
		$products = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
			->addStoreFilter()
			->setOrder($this->getConfig('sort'),$this->getConfig('direction'))
			//->addAttributeToFilter("featured", 1);	
			->addFieldToFilter(array(
			array('attribute'=>'featured','eq'=>'1'),
			));	
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
		$config = Mage::getStoreConfig('featuredproduct');
		if (isset($config['featuredproduct_config'][$att]) ) {
			$value = $config['featuredproduct_config'][$att];
			return $value;
		}
	}
}