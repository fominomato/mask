<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
define(deploy_id, "1");

define(errorApp, "Erro: não encontramos uma aplicação associada!");
define(errorTyp, "Erro: não encontramos um processo associado!");
define(errorFlow, "Erro: não encontramos um fluxo associado!");
define(errorDpl, "Erro: Duplicidade de processo para uma aplicação!");

Class Zend_Controller_Action_Helper_Process extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir ou atualizar um processo
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		try{
			$rsOut = self::check($data);
			if(!$rsOut)
			{
				$process					= new Application_Model_ProcessMapper();
				if($data['type_id'] == deploy_id)
					$data['package_id'] 	= self::savePackage($data, $process);
		
				return $process->save($data);
			}			
			return $rsOut;
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
	 * Método para armazenar os pacotespara um deploy
	 * @param array $data
	 */
	public static function savePackage ($data, $process = null)
	{
		if($process)
			$data['flow_component_id'] = $process;
		$mapper = new Application_Model_PackageMapper();
		return $mapper->save($data);
	}
	
	/**
	 * Metodo para armazenar fluxos
	 * @param array $data
	 */
	public static function saveFlow ($data)
	{
		try{
			$mapper = new Application_Model_FlowMapper();
			if(is_array($data['flow_id']))
				foreach($data['flow_id'] as $flow)
					$mapper->save($data, $flow);
			else
				$mapper->save($data);
		}
		catch(Exception $e){
			echo $e->getMessage();
			exit();
		}
	}	
	
	/**
	 * Retorna todos process
	 */
	public static function getAll($appCom = null)
	{
		if($appCom)
			$data = array("application_component_id"=>$appCom);
		$process= new Application_Model_ProcessMapper();
		$rsOut	= $process->fetchAll($data);
		if($rsOut)
			return $rsOut;
		return false;
	}
	
	/**
	 * Retorna um objeto do modelo de $process através de um id
	 * @param $data string (dados de usuário)
	 */
	public static function get($process_id)
	{
		$process			= new Application_Model_Process();
		$processMapper		= new Application_Model_ProcessMapper();
		$processMapper->find($process_id, $process);
		return $process;
	}
		
	/**
	 * Metodo para Preencher um modelo de process
	 * @param $data string (dados de usuário)
	 * @return Application_Model_Process()
	 */
	public static function setProcess($data)
	{
		$objProcess = new Application_Model_Process();
		$objProcess->setId($data['server_id']);
		$objProcess->setType($data['type_id']);
		$objProcess->setPackage($data['package_id']);
		$objProcess->setFlow($data['command_flow_id']);
		$objProcess->setAppCom($data['application_component_id']);
		return $objProcess; 
	}

	function setPackage($data)
	{
		$objPackage = new Application_Model_Package();
		$objPackage->setId($data['package_id'])
				->setSource($data['source_path'])		
				->setDeploy($data['deploy_path'])
				->setHistory($data['history_path']);
		return $objPackage; 
	}
	
	/**
	 * Remover um determinado process
	 * @param $process_id int (id do process)
	 */
	public static function remove($process_id)
	{
		$processMapper	= new Application_Model_ProcessMapper();
		return $processMapper->remove($process_id);
	}
 
}