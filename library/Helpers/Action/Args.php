<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
define(sucessInsert, "<div class='sucess'>Registro inserido. Agora selecione um produto.</div>");
define(errorInsert, "<div class='error'>Registro não foi inserido.</div>");
define(sucessRemove, "<div class='sucess'>Registro removido.</div>");
define(errorRemove, "<div class='error'>Registro não foi removido.</div>");
define(sucessUpdate, "<div class='sucess'>Registro atualizado.</div>");
define(errorUpdate, "<div class='error'>Registro não foi atualizado.</div>");
define(errorDpl, "<div class='error'>Erro: Já existe registro com estes dados!</div>");

Class Zend_Controller_Action_Helper_Args extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir um component
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		try{
			$mapper	= new Application_Model_ArgsMapper();
			if(($rs = $mapper->save($data)) > 0)
				return array("return"=>1, "message"=>sucessUpdate, "id"=>$rs);
				
			if(strchr(strtolower($rs), "duplicate"))
				if(($id = $mapper->update($data)) > 0)
					return array("return"=>1, "message"=>sucessUpdate, "id"=>$id);
				else
					$rsOut = errorDpl;
			return array("return"=>2, "message"=>errorInsert);
		}
		catch(Exception $e)
		{
			$rsOut = $e->getMessage();
			if(strchr(strtolower($rsOut), "duplicate"))
				if(($id = $mapper->update($data)) > 0)
					return array("return"=>1, "message"=>sucessInsert, "id"=>$id);
				else
					$rsOut = errorDpl;
		}
		return array("return"=>2, "message"=>$rsOut);
	}

	
	/**
	 * Remover um determinado argumento
	 * @param array de (id's) comp e command
	 */
	public static function remove($data)
	{
		$componentMapper	= new Application_Model_ArgsMapper();
		if($componentMapper->remove($data) > 0)
			return sucessRemove;
		return errorRemove;
	}
		
	/**
	 * método para atualizar um argumento9
	 * @param $data array com dados do post
	 */
	public static function update($data)
	{
		$mapper	= new Application_Model_ArgsMapper();
		if($mapper->update($data))
			return sucessUpdate;
		return errorUpdate;
	}	
	
}