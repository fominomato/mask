<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
Class Zend_Controller_Action_Helper_Search extends Zend_Controller_Action_Helper_Abstract
{
	
	/**
	 * Retorna todas execuções (operações)
	 */
	public static function getOperations($data=null)
	{
		$procMapper	= new Application_Model_ProcessMapper();
		return $procMapper->fetchAll($data);
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
		var_dump($objFlow);
		exit();
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
}