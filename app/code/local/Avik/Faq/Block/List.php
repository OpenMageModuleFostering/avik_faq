 <?php
class Avik_Faq_Block_List extends Mage_Core_Block_Template {
   
  public function __construct()
	{
		parent::__construct();
		$collection = Mage::getModel('avik_faq/faq')->getCollection();
		
		$this->setCollection($collection);
	}
  protected function _prepareLayout()
	{
		parent::_prepareLayout();

		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		$pager->setCollection($this->getCollection());
		$this->setChild('pager', $pager);
		$this->getCollection()->load();

		return $this;
	}

	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}
	public function getCollection()
	{
		$__helper = Mage::helper('avik_faq');
		$limit = ($__helper->getPaginationLimit() != '')?$__helper->getPaginationLimit():10;
		$curr_page = 1;

		if(Mage::app()->getRequest()->getParam('p'))
		{
		$curr_page = Mage::app()->getRequest()->getParam('p');
		}
		$offset = ($curr_page - 1) * $limit;
		$collection = Mage::getModel('avik_faq/faq')->getCollection();
		$store_id=Mage::app()->getStore()->getStoreId();
		$collection->addFieldToFilter('is_active', array('eq' =>1))->addStoreFilter($store_id);
		$collection->getSelect()->limit($limit,$offset);
		return $collection;
	}


   
}