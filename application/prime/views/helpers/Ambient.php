<?php
/**
 * Arquivo para apresentar um option box para tipo de ambientes
 * @author guarient
 *
 */

class Zend_View_Helper_Ambient extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos ambientes
	 * @param array $data
	 */
	public function ambient (Application_Model_Ambient $data=null)
	{
		if($data)
			$id = $data->getId();
			
		$ambientMapper	= new Application_Model_AmbientMapper();
		$lsObjects		= $ambientMapper->fetchAll();

		return self::createBox($lsObjects, $id);	
	}
	
	/**
	 * Metodo para criar o box de tipos de ambient
	 * @param array $objects (array com objeto para cada nó)
	 */
	public static function createBox($objects, $id = null)
	{
		$htmlOut = "<select name='ambient_id' id='ambient_id' size='3' style='margin: 5px!important;'>";
		foreach($objects as $object)
		{
			if($object->getId() == $id)
				$htmlOut.= "<option selected='true' value='{$object->getId()}'>{$object->getName()}</option>";
			else
				$htmlOut.= "<option value='{$object->getId()}'>{$object->getName()}</option>";
		}
		return ($htmlOut."</select>");
	}
}
?>