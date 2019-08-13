<?php
class Avik_Faq_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_FAQ_TITLE = 'faq_options_new/messages/faq_title';
	const XML_PAGINATION_LIMIT = 'faq_options_new/messages/pagination_limit';
	public function getFaqTitle()
	{
		return Mage::getStoreConfig(self::XML_FAQ_TITLE);
	}
	public function getPaginationLimit()
	{
		return Mage::getStoreConfig(self::XML_PAGINATION_LIMIT);
	}
	
	public function filter($content){
		return Mage::helper('cms')->getBlockTemplateProcessor()->filter($content);
	}
}