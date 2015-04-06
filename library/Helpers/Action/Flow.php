<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
define(sucessInsert, 	"<div class='sucess'>Registro inserido.</div>");
define(errorInsert, 	"<div class='error'>Error: registro não inserido.</div>");
define(sucessRemove,	"<div class='sucess'>Registro removido.</div>");
define(errorRemove,		"<div class='error'>Error: registro não removido.</div>");

Class Zend_Controller_Action_Helper_Flow extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir ou atualizar um fluxo
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		try{
			if($data['command_flow_id'] > 0 ){
				$flowMapper	= new Application_Model_FlowMapper();
				return $flowMapper->save($data);
			}
			return errorInsert;
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
	 * Retorna todos fluxos
	 */
	public static function getAll($data=null)
	{
		$flowMapper	= new Application_Model_FlowMapper();
		$rsOut		= $flowMapper->fetchAll($data);
		if($rsOut)
			return $rsOut;
		return false;
	}
	
	/**
	 * Retorna um objeto do modelo de $flow através de um id
	 * @param $data string (dados de usuário)
	 */
	public static function get($flow_command_id)
	{
		$flow		= new Application_Model_Flow();
		$flowMapper	= new Application_Model_FlowMapper();
		$flowMapper->find($flow_command_id, $flow);
		return $flow;
	}
		
	/**
	 * Metodo para Preencher um modelo de fluxo
	 * @param $data string (dados de usuário)
	 * @return Application_Model_Flow()
	 */
	public static function setFlow($data)
	{
		$objFlow = new Application_Model_Flow();
		$objFlow->setId($data['flow_command_id']);
		$objFlow->setCommand($data['command_id']);		
		$objFlow->setFlow($data['flow_id']);

		return $objFlow; 
	}	
	
	/**
	 * Remover um determinado fluxo
	 * @param $process_id int (id do fluxo)
	 */
	public static function remove($flow_id)
	{
		$flowMapper	= new Application_Model_FlowMapper();
		return $flowMapper->remove($flow_id);
	}

	/**
	 * Metodo para associação de fluxo ao produto ou sub
	 * @param array $data
	 * @return string 
	 */
	public function flowAssoc($data)
	{
		if($data['command_flow_id'] > 0 && $data['product_id'] > 0 ){
			$mapper = new Application_Model_CommandProductMapper();
			$message = $mapper->save($data);
			if($message > 0 || is_numeric($message))
				return sucessInsert;
			elseif(is_string($message))
				return $message;
		}
		return errorInsert;
	}


	/**
	 * Metodo para desassociação de fluxo ao produto ou sub
	 * @param array $data
	 * @return string 
	 */
	public function removeAssoc($data)
	{
		$mapper = new Application_Model_CommandProductMapper();
		if($mapper->remove($data))
			return sucessRemove;
		return errorRemove;
	}		
}