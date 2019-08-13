<?php
class Avik_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {   
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
            ->renderLayout();
    }   
    protected function _getModel(){
		return Mage::getModel('avik_faq/faq');
	}
    public function newAction()
    {   
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }   
     
    public function editAction()
    {   
       
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('avik_faq/faq');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This faq no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }   
        }   
     
        $this->_title($model->getId() ? $model->getName() : $this->__('New Faq'));
     
        $data = Mage::getSingleton('adminhtml/session')->getFaqData(true);
        if (!empty($data)) {
            $model->setData($data);
        }   
     
        Mage::register('avik_faq', $model);
     
        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Faq') : $this->__('New Faq'), $id ? $this->__('Edit Faq') : $this->__('New Faq'))
            ->_addContent($this->getLayout()->createBlock('avik_faq/adminhtml_faq_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }
    public function getAllStore(){
		$allStores = Mage::app()->getStores();
		$storeId=array();
		foreach ($allStores as $_eachStoreId => $val)
		{
			$storeId[] = Mage::app()->getStore($_eachStoreId)->getId();
		}
		return implode(',',$storeId);
	}
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('avik_faq/faq');
			if(isset($postData['stores'])) {
			    if(in_array('0',$postData['stores'])){
			        $postData['store_id'] = $this->getAllStore();
			     }
			    else{
			        $postData['store_id'] = implode(",", $postData['stores']);
			        
			    }
			   	unset($postData['stores']);
			}
			
			
            $model->setData($postData);
 
            try {
                $model->save();
 				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The faq has been saved.'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
 				return;
            }   
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this faq.'));
            }
 
            Mage::getSingleton('adminhtml/session')->setBazData($postData);
            $this->_redirectReferer();
        }
    }
    public function deleteAction(){
		 $id  = $this->getRequest()->getParam('id');
         $model = Mage::getModel('avik_faq/faq');
		 try{
		 	$model->setId($id)->delete();
		    Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The faq has been deleted successfully.'));
            $this->_redirect('*/*/');
		 }
		 catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while Deleting this faq.'));
            }
		 
	} 
	 public function massDeleteAction() {

		$IDList = $this->getRequest()->getParam('avikfaq');
		
        if(!is_array($IDList)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select record(s)'));
        } else {
            try {
                foreach ($IDList as $itemId) {
                    $model = $this->_getModel()
                            ->setIsMassDelete(true)
                            ->load($itemId);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($IDList)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        //$this->_redirect('*/*/index');
		  $this->_redirect('*/*/');
    }
    public function messageAction()
    {
        $data = Mage::getModel('avik_faq/faq')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
     
    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
            // Make the active menu match the menu config nodes (without 'children' inbetween)
            ->_setActiveMenu('sales/avik_faq_faq')
            ->_title($this->__('Sales'))->_title($this->__('Faq'))
            ->_addBreadcrumb($this->__('Sales'), $this->__('Sales'))
            ->_addBreadcrumb($this->__('Faq'), $this->__('Faq'));
         
        return $this;
    }
     
    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/avik_faq_faq');
    }
}