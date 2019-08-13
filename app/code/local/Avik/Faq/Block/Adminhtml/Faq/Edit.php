<?php
class Avik_Faq_Block_Adminhtml_Faq_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /** 
     * Init class
     */
    public function __construct()
    {   
        $this->_blockGroup = 'avik_faq';
        $this->_controller = 'adminhtml_faq';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save Faq'));
        $this->_updateButton('delete', 'label', $this->__('Delete Faq'));
		$this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
		$this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }   
     protected function _prepareLayout() {
	    parent::_prepareLayout();
	    if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
	        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
	    }
	}
    /** 
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {   
        if (Mage::registry('avik_faq')->getId()) {
           return $this->__('Edit Faq');
       }   
       else {
          return $this->__('New Faq');
        }   
    }   
}