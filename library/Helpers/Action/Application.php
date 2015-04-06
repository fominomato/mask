<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
//lista de erros
define (dplAppcom,		"<div class='error'>Erro: Já existe registro com estes dados!</div>");
define (dplApp, 		"<div class='error'>Erro: Já existe aplicação com estes dados!</div>");
define (dplAppCom, 		"<div class='error'>Erro: Já existe um cadastro de Aplicação x Componente!</div>");
define (sucessInsert, 	"<div class='sucess'>Registro inserido!</div>");
define (errorInsert, 	"<div class='error'>Registro não inserido!</div>");
define (sucessRemove, 	"<div class='sucess'>Registro removido!</div>");
define (errorRemove, 	"<div class='error'>Registro não removido!</div>");

Class Zend_Controller_Action_Helper_Application extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir ou atualizar um cliente
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		$validApp		= new App_Plugins_Valid_Application();
		try{
			if($validApp->isValid($data))
			{
				$application	= new Application_Model_ApplicationMapper();
				if($data['name']){
					$data['application_id']	= $application->save($data);
					if($data['application_id'] == false)
						return dplApp;
				}
		        $appComp = new Application_Model_ApplicationComponentMapper();
		        if($appComp->save($data))
		        {
		        	$mapperComp = new Application_Model_ComponentMapper();
		        	$entries 	= $mapperComp->getAll($data['component_id']); 
		        	foreach($entries as $entry)
		        	{
		        		$data['component_id'] = $entry;
		        		$appComp->save($data);	
		        	}
		        	return sucessInsert;
		        }
		        return errorInsert;
			}
			else
				return implode("<br />",$validApp->getMessages());
		}
		catch(Exception $e)
		{
			$rsOut = $e->getMessage();
			if(strchr(strtolower($rsOut), "duplicate"))
				return dplAppcom;
		}
	}
	
	/**
	 * Remover um determinado application
	 * @param array $data
	 */
	public static function remove($data)
	{
		$applicationMapper	= new Application_Model_ApplicationComponentMapper();
		if($applicationMapper->remove($data))
			return sucessRemove;
		return errorRemove;
	}
}