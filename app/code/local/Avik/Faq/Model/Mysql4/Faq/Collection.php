<?php
class Avik_Faq_Model_Mysql4_Faq_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {   
        $this->_init('avik_faq/faq');
    } 
	public function addStoreFilter($store, $withAdmin = true){

	    if ($store instanceof Mage_Core_Model_Store) {
	        $store = array($store->getId());
	    }

	    if (!is_array($store)) {
	        $store = array($store);
	    }
		$this->addFilter('store_id', array('in' => $store));

	    return $this;
	}  
}