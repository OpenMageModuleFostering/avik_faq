<?php
class Avik_Faq_Block_Adminhtml_Faq extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        // The blockGroup must match the first half of how we call the block, and controller matches the second half
        // ie. foo_bar/adminhtml_baz
        $this->_blockGroup = 'avik_faq';
        $this->_controller = 'adminhtml_faq';
        $this->_headerText = $this->__('Faq');
         
        parent::__construct();
    }
}