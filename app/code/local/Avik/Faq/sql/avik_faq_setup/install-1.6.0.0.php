<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
 
/**
 * Create table 'foo_bar_baz'
 */
 
 try{
 $table = $installer->getConnection()
    // The following call to getTable('foo_bar/baz') will lookup the resource for foo_bar (foo_bar_mysql4), and look
    // for a corresponding entity called baz. The table name in the XML is foo_bar_baz, so ths is what is created.
    ->newTable($installer->getTable('avik_faq/faq'))
    ->addColumn('faq_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Faq_Id')
    ->addColumn('faq_title', Varien_Db_Ddl_Table::TYPE_CLOB, 0, array(
        'nullable'  => false,
        ), 'Faq_Title')
	->addColumn('faq_description', Varien_Db_Ddl_Table::TYPE_TEXT,NULL, array(
        'nullable'  => false,
        ), 'Faq_Description')
	->addColumn('faq_date', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable'  => false,
        ), 'Faq_Date')
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable'  => false,
        ), 'Store_Id')
	->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_INTEGER,1, array(
        'nullable'  => false,
        'default'  => 1,
        ), 'Is_Active');
$installer->getConnection()->createTable($table);
 }
 catch(Exception $e){
 	echo $e->getMessage();
	die;
 }
$installer->endSetup();