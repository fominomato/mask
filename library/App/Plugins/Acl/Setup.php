<?php


class App_Plugins_Acl_Setup
{
	/**
	 * @var Zend_Acl
	 */
	protected $_acl;

	public function __construct()
	{
		$this->_acl = new Zend_Acl();
		$this->_initialize();
	}

	protected function _initialize()
	{
		$this->_setupRoles();
		$this->_setupResources();
		$this->_setupPrivileges();
		$this->_saveAcl();
	}

	protected function _setupRoles()
	{
		$this->_acl->addRole( new Zend_Acl_Role('default') );
		$this->_acl->addRole( new Zend_Acl_Role('prime'), 'default' );
		$this->_acl->addRole( new Zend_Acl_Role('admin'), 'prime' );
	}

	protected function _setupResources()
	{
		$this->_acl->addResource( new Zend_Acl_Resource('auth'));
		$this->_acl->addResource( new Zend_Acl_Resource('error'));
		$this->_acl->addResource( new Zend_Acl_Resource('index'));
	}

	protected function _setupPrivileges()
	{
		$this->_acl->allow( 'default', null, array('index', 'auth', 'find', 'exec'));
		$this->_acl->allow( 'prime', null, array('appliance', 'client', 'component', 'flow', 'process', 'server'));
		$this->_acl->allow( 'admin');
	}

	protected function _saveAcl()
	{
		$registry = Zend_Registry::getInstance();
		$registry->set('acl', $this->_acl);
	}
}
