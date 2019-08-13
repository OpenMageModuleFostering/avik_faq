<?php
class Avik_Faq_Block_Adminhtml_Faq_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        // Set some defaults for our grid
        $this->setDefaultSort('faq_id');
        $this->setId('avik_faq_faq_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }
     
    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'avik_faq/faq_collection';
    }
    protected function _filterStoreCondition($collection, $column){
	    if (!$value = $column->getFilter()->getValue()) {
	        return;
	    }
		
	    $this->getCollection()->addStoreFilter($value);
		
	}
	
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
		
		foreach($collection as $link){
			if($link->getStoreId() && $link->getStoreId() != 0 ){
			
	           $link->setStoreId(explode(',',$link->getStoreId()));
	        }
	        else{
	            $link->setStoreId(array('0'));
	        }
			
		
    	}
		
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }
     
    protected function _prepareColumns()
    {
        // Add the columns that should appear in the grid
        $this->addColumn('faq_id',
            array(
                'header'=> $this->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'faq_id'
            )
        );
         
        $this->addColumn('faq_title',
            array(
                'header'=> $this->__('Name'),
				
                'index' => 'faq_title'
            )
        );
		if (!Mage::app()->isSingleStoreMode()) {
		    $this->addColumn('store_id', array(
		        'header'        => $this->__('Store View'),
		        'index'         => 'store_id',
		        'type'          => 'store',
		        'store_all'     => true,
		        'store_view'    => true,
		        'sortable'      => true,
		        'filter_condition_callback' => array($this,
		            '_filterStoreCondition'),
		    ));
		}
		$this->addColumn('is_active',
            array(
                'header'=> $this->__('Status'),
				'type'  =>'options',
                'index' => 'is_active',
				'options' => Mage::getSingleton('catalog/product_status')->getOptionArray()
            )
        );
          $this->addColumn('faq_date',
            array(
                'header'=> $this->__('Date Added'),
                'index' => 'faq_date'
            )
        );
        return parent::_prepareColumns();
    }
     protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('avikfaq');
        
        $this->getMassactionBlock()->addItem('delete', array(
             'label' => Mage::helper('avik_faq')->__('Delete'),
             'url'   => $this->getUrl('*/*/massDelete')
        ));

        return $this;
    }
    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}