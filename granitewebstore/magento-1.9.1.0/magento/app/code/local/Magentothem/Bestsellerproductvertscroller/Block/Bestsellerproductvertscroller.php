<?php
class Magentothem_Bestsellerproductvertscroller_Block_Bestsellerproductvertscroller extends Mage_Catalog_Block_Product_Abstract
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getBestsellerproductvertscroller()     
     { 
        if (!$this->hasData('bestsellerproductvertscroller')) {
            $this->setData('bestsellerproductvertscroller', Mage::registry('bestsellerproductvertscroller'));
        }
        return $this->getData('bestsellerproductvertscroller');
        
    }
	public function getProducts()
    {
    	$storeId    = Mage::app()->getStore()->getId();
	$cateids = $this->getConfig('catsid');
	$arr_catid = explode(",", $cateids);
	if($cateids != null)	
    	    {
		$arr_productids = $this->getProductByCategory();
		$products = Mage::getResourceModel('reports/product_collection')
		//->addAttributeToSelect('*')
    		->addOrderedQty()
		->addMinimalPrice()
		->addAttributeToSelect(array('name', 'price', 'small_image'))
		->setStoreId($storeId)
		->addStoreFilter($storeId)
		->setOrder('ordered_qty', 'desc');
				$products->joinField('category_id',
				    'catalog/category_product',
				    'category_id',
				    'product_id=entity_id',
				    null,
				    'left');
		$products->addAttributeToFilter('category_id', array('in' => $arr_catid));
	    }
	    else {
		$products = Mage::getResourceModel('reports/product_collection')
    		->addOrderedQty()
		//->addAttributeToSelect('*')
		->addMinimalPrice()
		->addAttributeToSelect(array('name', 'price', 'small_image'))
		->setStoreId($storeId)
		->addStoreFilter($storeId)
		->setOrder('ordered_qty', 'desc');	
	    }	
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
	//$pro_Ids = array();
	//foreach($products as $product){
		//$pro_Ids[] = $product->getId();
	//}
	//$colection = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter('entity_id', array('in' => $pro_Ids)); 
        $this->setProductCollection($products);
    }
	public function getConfig($att) 
	{
		$config = Mage::getStoreConfig('bestsellerproductvertscroller');
		if (isset($config['bestsellerproductvertscroller_config']) ) {
			$value = $config['bestsellerproductvertscroller_config'][$att];
			return $value;
		} else {
			throw new Exception($att.' value not set');
		}
	}
}