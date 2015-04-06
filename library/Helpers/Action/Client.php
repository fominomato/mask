<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
Class Zend_Controller_Action_Helper_Client extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir ou atualizar um cliente
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		$objClient = self::setClient($data);
		try{
			$client	= new Application_Model_ClientMapper();
			$rsOut	= $client->save($objClient);
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
	 * Retorna todos cliente
	 * @param $data string (dados de usuário)
	 */
	public static function getAll($data)
	{
		$client	= new Application_Model_ClientMapper();
		$rsOut	= $client->fetchAll();
		if($rsOut)
			return $rsOut;
		return false;
	}
	
	/**
	 * Retorna um objeto do modelo de cliente através de um id
	 * @param $data string (dados de usuário)
	 */
	public static function get($client_id)
	{
		$client			= new Application_Model_Client();
		$clientMapper	= new Application_Model_ClientMapper();
		$clientMapper->find($client_id, $client);
		return $client;
	}
		
	/**
	 * Metodo para Preencher um modelo de cliente
	 * @param $data string (dados de usuário)
	 * @return Application_Model_Client()
	 */
	public static function setClient($data)
	{
		$objClient = new Application_Model_Client();
		$objClient->setId($data['client_id']);
		$objClient->setName($data['name']);		
		$objClient->setSite($data['site']);
		return $objClient; 
	}	
	
	/**
	 * Remover um determinado cliente
	 * @param $client_id int (id do cliente)
	 */
	public static function remove($client_id)
	{
		$clientMapper	= new Application_Model_ClientMapper();
		return $clientMapper->remove($client_id);
	}	
}