<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
define (dplAppcom,		"<div class='error'>Erro: Já existe registro com estes dados!</div>");
define (dplApp, 		"<div class='error'>Erro: Já existe aplicação com estes dados!</div>");
define (dplAppCom, 		"<div class='error'>Erro: Já existe um cadastro de Aplicação x Componente!</div>");
define (sucessInsert, 	"<div class='sucess'>Registro inserido!</div>");
define (sucessUpdate, 	"<div class='sucess'>Registro atualizado!</div>");
define (errorInsert, 	"<div class='error'>Registro não inserido!</div>");
define (errorUpdate, 	"<div class='error'>Registro não atualizado!</div>");
define (sucessRemove, 	"<div class='sucess'>Registro removido!</div>");
define (errorRemove, 	"<div class='error'>Registro não removido!</div>");


Class Zend_Controller_Action_Helper_User extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir ou atualizar um cliente
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		$mapper			= new Application_Model_UserMapper();
		$validUser		= new App_Plugins_Valid_User();
		try{
			if($validUser->isValid($data))
			{
				$user_id = $mapper->save($data);
		        if($user_id){
					return sucessInsert;
		        }else{
	        		return errorInsert;
				}
			}
		    return implode("<br />", $validUser->getMessages());
		}
		catch(Exception $e)
		{
			$rsOut = $e->getMessage();
			if(strchr(strtolower($rsOut), "duplicate"))
				return dplAppcom;
		}
	}
		
	public static function update($data)
	{
		try{
			
			$mapper				= new Application_Model_UserMapper();
			$data['client_id']	= split(",", $data['client_id']);
	        $value				= $mapper->serialUser($data);	        	
			$user_id			= $mapper->save($data);
			
	        if($user_id){
				$mapper->saveLog($data, $value);
	        	return sucessUpdate;				
	        }else{
        		return errorUpdate;
	        }
		}
		catch(Exception $e)
		{
			$rsOut = $e->getMessage();
			if(strchr(strtolower($rsOut), "duplicate"))
				return dplAppcom;
		}
	}
		
	public static function updt_pass ($data)
	{
		try{
			
			$mapper				= new Application_Model_UserMapper();
			$update['user_id']	= $data['user_id'];
			$update['pass']		= rand(0,89).date("His", time());

			if($mapper->resetPass($update)){
				$mapper->saveLog($data, "mudança de senha");
	        	return sucessUpdate;				
	        }else{
        		return errorUpdate;
	        }
		}
		catch(Exception $e)
		{
			$rsOut = $e->getMessage();
			if(strchr(strtolower($rsOut), "duplicate"))
				return dplAppcom;
		}
	}
			
	/**
	 * Metodo para Preencher um modelo de um ususrio
	 * @param $data string 
	 * @return Application_Model_User()
	 */
	public static function setUser($data)
	{	
		$user = new Application_Model_User();
		$user->setLogin($data['login']);
		$user->setName($data['name']);		
		return $user; 
	}

	public static function getUser($data=null)
	{
		$mapper	= new Application_Model_UserMapper();
		return $mapper->fetchAllUsers($data);
	}
	
	/**
	 * Remover um determinado usuário
	 * @param $data array 
	 */
	public static function remove($data)
	{
		$mapper	= new Application_Model_UserMapper();
		if($mapper->remove($data))
			return sucessRemove;			
		return errorRemove;
	}
}