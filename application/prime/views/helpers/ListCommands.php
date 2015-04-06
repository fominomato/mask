<?php
/**
 * Valida se precisa de argumentos
 * @author guarient
 *
 */

class Zend_View_Helper_ListCommands extends Zend_View_Helper_Abstract
{

	protected $data;
	
	/**
	 * Metodo para listar tos comandos de um produte responder se necessita de argumentos
	 * @param int $product_id
	 */
	public function ListCommands ($product_id=null)
	{
		$flowMapper	= new Application_Model_CommandProductMapper();
		$lsObj		= $flowMapper->fetchAll(array("product_id"=>$product_id));
		return self::validArgs($lsObj);	
	}
	
	/**
	 * Metodo para validar Argumentos
	 * @param array $object (array com objeto para cada nó)
	 */
	public static function validArgs($objects)
	{
		if(count($objects) > 0 && $objects)
			foreach($objects as $object)
				if(strstr($object->getCommand()->getCommand()->getName(), "[#instancia]"))
					return true;
				
		return false;
	}
}
?>