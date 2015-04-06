<?php
/**
 * Arquivo para processar um option box para Prod
 * @author guarient
 *
 */

class Zend_View_Helper_Tree extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para retornar a arvore de componentes pais apartir de um component
	 * @param int $id
	 */
	public function Tree($id)
	{
		$compMapper	= new Application_Model_ComponentMapper();		
		$component = $compMapper->findbyId($id);
		if($component)
			return self::createList($component);
		return false;
	}
	
	/**
	 * Metodo para criar o html da lista
	 * @param array $servers (array com objeto para cada nó)
	 */
	public static function createList($object)
	{
		$compMapper	= new Application_Model_ComponentMapper();
		$rsOut		= array();
		$rsOut[0]	= $object;
		$a = 1;
		do
		{
			$object	= $compMapper->findbyId($object->getComponentId());
			if($object)
			{
				$rsOut[$a] = $object;
				$a++;
			}
		}
		while($object != false);
		return $rsOut;
	}
	
}
?>