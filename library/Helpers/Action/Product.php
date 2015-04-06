<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
define(update, 		"<div class='sucess'>Registro atualizado</div>!");
define(insert, 		"<div class='sucess'>Registro inserido!</div>");
define(removeSucess,"<div class='sucess'>Registro removido com sucesso!.</div>");
define(removeFail, 	"<div class='error'>Registro não removido!.</div>");

Class Zend_Controller_Action_Helper_Product extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * método para inserir ou atualizar um cliente
	 * @param $data array com dados do post
	 */
	public static function save($data)
	{
		try{
			$valid = new App_Plugins_Valid_Product();
			if($valid->isValid($data))
			{
				$product		= new Application_Model_ProductMapper();
				$rsOut			= $product->save($data);
				return ($data['id']>0)?update:insert;
			}
			return  implode("<br style='clear:both'/>",$valid->getMessages());
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
	 * Retorna todos produtos de um cliente
	 * @param $data string (dados de usuário)
	 */
	public static function getAll($data)
	{
		$product	= new Application_Model_ProductMapper();
		$rsOut		= $product->fetchAll();
		if($rsOut)
			return $rsOut;
		return false;
	}
	
	/**
	 * Retorna um objeto do modelo de product através de um id
	 * @param int $product_id 
	 */
	public function get($product_id)
	{
		$product		= new Application_Model_Product(array("product_id"=>$product_id));
		$productMapper	= new Application_Model_ProductMapper();
		$productMapper->find($product_id, $product);
		return $product;
	}
		
	/**
	 * Metodo para Preencher um modelo de uma product
	 * @param $data string 
	 * @return Application_Model_Product()
	 */
	public static function setClient($data)
	{
		$objProduct = new Application_Model_Product();
		$objProduct->setId($data['product_id']);
		$objProduct->setName($data['name']);		
		return $objProduct; 
	}	
	
	/**
	 * Remover um determinado product
	 * @param $product_id int (id do product)
	 */
	public static function remove($product_id)
	{
		$productMapper	= new Application_Model_ProductMapper();
		$rsOut			= $productMapper->remove($product_id);
		if($rsOut)
			return removeSucess;
		return removeFail;
	}
}