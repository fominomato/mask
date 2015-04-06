<?php
/**
* This is the DbTable class for the user table.
*/
class Application_Model_DbTable_FlowComponent extends Zend_Db_Table_Abstract
{
    /** Table name */
    protected $_schema  = 'hbtconsole';
	protected $_name    = 'Flow_Component';
	protected $_primary = 'flow_component_id';	
}