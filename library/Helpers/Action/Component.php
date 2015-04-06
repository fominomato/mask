<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
define(sucessInsert, "<div class='sucess'>Registro inserido. Agora selecione um produto.</div>");
define(errorInsert, "<div class='error'>Registro não foi inserido.</div>");
define(sucessRemove, "Registro removido.");
define(errorRemove, "Registro não foi removido.");
define(sucessUpdate, "<div class='sucess'>Registro atualizado.</div>");
define(errorUpdate, "<div class='error'>Registro não foi atualizado.</div>");

Class Zend_Controller_Action_Helper_Component extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir um component
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		$valid = new App_Plugins_Valid_Component();
		try{
			if($valid->isValid($data))
			{
				$component	= new Application_Model_ComponentMapper();
				if(empty($data['component_id']) || $data['component_id'] < 1)
				{
					if(($id = $component->save($data)) > 0)
						return array("return"=>1, "message"=>sucessInsert, "id"=>$id);
					return array("return"=>2, "message"=>errorInsert);
				}
				
				if(($rsOut = $component->save($data)))
					return array("return"=>1, "message"=>sucessInsert, "product_id"=>$rsOut['product_id'], "id"=>$rsOut['id']);
				return array("return"=>2, "message"=>errorInsert);
			}
			return array("return"=>2, "message"=>implode("<br />", $valid->getMessages()));
		}
		catch(Exception $e)
		{
			$rsOut = $e->getMessage();
			if(strchr(strtolower($rsOut), "duplicate"))
				$rsOut = "<div class='error'>Erro: Já existe registro com estes dados!</div>";
		}
		return array("return"=>2, "message"=>$rsOut);
	}
	
		
	/**
	 * Metodo para Preencher um modelo de um component
	 * @param $data string 
	 * @return Application_Model_Component()
	 */
	public static function setComponent($data)
	{
		$objComponent = new Application_Model_Component();
		$objComponent->setId($data['component_id']);
		$objComponent->setName($data['title']);
		$objComponent->setComponentId($data['component_component_id']);
		$objComponent->setProduct($data['product_id']);
		return $objComponent; 
	}	
	
	/**
	 * Remover um determinado component
	 * @param $component_id int (id do component)
	 */
	public static function remove($component_id)
	{
		$componentMapper	= new Application_Model_ComponentMapper();
		if($componentMapper->remove($component_id) > 0)
			return sucessRemove;
		return false;
	}
		
	/**
	 * método para atualizar um component
	 * @param $data array com dados do post
	 */
	public static function update($data)
	{
		try{
			if($data['product_id'] > 0 && $data['component_id'] > 0)
			{
				$component	= new Application_Model_ComponentMapper();
				if($component->update($data))
					return sucessUpdate;
				return errorUpdate;
			}
			return "<div class='error'>Erro: selecione um produto e um componente.</div>";
		}
		catch(Exception $e)
		{
			$rsOut = $e->getMessage();
			if(strchr(strtolower($rsOut), "duplicate"))
				$rsOut = "<div class='error'>Erro: Já existe registro com estes dados!</div>";
		}
		return $rsOut;
	}	
	
}