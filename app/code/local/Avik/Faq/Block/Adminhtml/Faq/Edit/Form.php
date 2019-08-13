<?php
class Avik_Faq_Block_Adminhtml_Faq_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /** 
     * Init class
     */
    public function __construct()
    {   
        parent::__construct();
     
        $this->setId('foo_faq_faq_form');
        $this->setTitle($this->__('Faq Information'));
    }   
     
    /** 
     * Setup form fields for inserts/updates
     * 
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {   
        $model = Mage::registry('avik_faq');
     
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        )); 
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Faq Information'),
            'class'     => 'fieldset-wide',
        )); 
     
        if ($model->getId()) {
            $fieldset->addField('faq_id', 'hidden', array(
                'name' => 'faq_id',
            )); 
        }   
     
        $fieldset->addField('faq_title', 'text', array(
            'name'      => 'faq_title',
            'label'     => Mage::helper('checkout')->__('Question'),
            'title'     => Mage::helper('checkout')->__('Question'),
            'required'  => true,
        )); 
		
		//if (!Mage::app()->isSingleStoreMode()) {
			    $fieldset->addField('store_id', 'multiselect', array(
			        'name' => 'stores[]',
			        'label' => Mage::helper('checkout')->__('Store View'),
			        'title' => Mage::helper('checkout')->__('Store View'),
			        'required' => true,
			        'values' => Mage::getSingleton('adminhtml/system_store')
			                     ->getStoreValuesForForm(false, true),
			    ));
		//}
		//else {
    			//$fieldset->addField('store_id', 'hidden', array(
			        //'name' => 'stores[]',
			        //'value' => Mage::app()->getStore(true)->getId()
    			//));
			//}
		 $fieldset->addField('faq_description', 'editor', 
                array (
                        'name' => 'faq_description', 
                        'label' => Mage::helper('avik_faq')->__('Answer'), 
                        'title' => Mage::helper('avik_faq')->__('Answer'), 
                        'style' => 'height:36em;',
                        'config'  => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
                        'state'     => 'html',
                        'required' => true,
                       ));
       $fieldset->addField('is_active', 'select', 
                array (
                        'label' => Mage::helper('avik_faq')->__('Status'), 
                        'title' => Mage::helper('avik_faq')->__('Item status'), 
                        'name' => 'is_active', 
                        'required' => true, 
                        'options' => array (
                                '1' => Mage::helper('avik_faq')->__('Enabled'), 
                                '2' => Mage::helper('avik_faq')->__('Disabled') ) 
                       ));
		 if (!$model->getId()) {
			$fieldset->addField('faq_date', 'select', 
                array (
                       
                        'name' => 'faq_date', 
						 'style' => 'display:none',
                        'required' => FALSE, 
                        'options' => array (
                                ''.Date('Y/m/d').'' => Mage::helper('avik_faq')->__('Enabled') 
                                 ) 
                       ));
		}
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }   
}