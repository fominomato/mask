<?php
/**
* This is the DbTable class for the user table.
*/
class Application_Model_DbTable_ApplicationComponent extends Zend_Db_Table_Abstract
{
    /** Table name */
    protected $_name    = 'Application_Component';
    protected $_primary = array('application_id', 'component_id', 'ambient_id');
	protected $_dependentTables = array('Application', 'Ambient', 'Component');
    
}