<?php

class Application_Model_User implements Zend_Acl_Role_Interface
{
	private $_login;
	private $_roleId;
	private $_name;
	private $clients;
	private $status;
	private $id;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}
	
	
	public function getLogin()
	{
		return $this->_login;
	}

	public function setLogin($login)
	{
		$this->_login = $login;
	}

	public function getName()
	{
		return $this->_Name;
	}

	public function setName($name)
	{
		$this->_Name = $name;
	}
	
	/**
	 * retorna o titulo do profile
	 */
	public function getRoleId()
	{
		return $this->_roleId;
	}

	public function setRoleId($roleId)
	{
		if(strlen($roleId) > 1)
		{
			$mapper = new Application_Model_ProfileMapper();
			$rsOut = $mapper->fetchAll(array("title" => $roleId));
			$this->_roleId = $rsOut[0]->profile_id;
		}
		else	
			$this->_roleId = $roleId;
	}
	
	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param $status the $status to set
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	public function getClients($profile=null, $id)
	{
		$mapper = new Application_Model_ClientuserMapper();
		return $mapper->findbyUser($profile, $id);	
	}
}
