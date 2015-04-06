<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
define(error,"Erro: Verifique os campos do formulario.");

Class Zend_Controller_Action_Helper_Server extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir ou atualizar um servidor
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		try{
			if(self::Check($data))
			{
				$server	= new Application_Model_ServerMapper();
				return $server->save($data);
			}
			return error;
		}
		catch(Exception $e)
		{
			$rsOut = $e->getMessage();
			if(strchr(strtolower($rsOut), "duplicate"))
				$rsOut = "Erro: Já existe registro com estes dados!";
		}
		return $rsOut;
	}
	
	/**
	 * Retorna todos servers
	 */
	public static function getAll()
	{
		$server	= new Application_Model_ServerMapper();
		$rsOut	= $server->fetchAll();
		if($rsOut)
			return $rsOut;
		return false;
	}
	
	/**
	 * Retorna um objeto do modelo de server através de um id
	 * @param $data string (dados de usuário)
	 */
	public static function get($server_id)
	{
		$server			= new Application_Model_Server(array("server_id"=>$server_id));
		$serverMapper	= new Application_Model_ServerMapper();
		$serverMapper->find($server_id, $server);
		return $server;
	}
		
	/**
	 * Metodo para Preencher um modelo de server
	 * @param $data string (dados de usuário)
	 * @return Application_Model_Server()
	 */
	public static function setServer($data)
	{
		$objServer = new Application_Model_Server();
		$objServer->setId($data['server_id']);
		$objServer->setAddress($data['address']);		
		$objServer->setPort($data['port']);
		return $objServer; 
	}	
	
	/**
	 * Remover um determinado server
	 * @param $server_id int (id do server)
	 */
	public static function remove($server_id)
	{
		$serverMapper	= new Application_Model_ServerMapper();
		return $serverMapper->remove($server_id);
	}

	/**
	 * Metodo para verificar se os campos foram preenchidos para inserção
	 * @param array $data 
	 */
	public static function Check($data)
	{
		if(empty($data['hostname']) && empty($data['ip']))
			return false;
			
		if(!is_numeric($data['port']))
			return false;
		return true;
	}
}