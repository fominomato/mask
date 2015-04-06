<?php
/**
 * Arquivo para apresentar um option box para tipo de application
 * @author guarient
 *
 */

class Zend_View_Helper_Application extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos application
	 * @param array $data
	 */
	public function application($data=null, $id=null)
	{
		$appMapper	= new Application_Model_ApplicationMapper();
		$lsObjects	= $appMapper->fetchforBox($data);
		if($lsObjects)
			return self::createBox($lsObjects, $id);	
	}
	
	/**
	 * Metodo para criar o box de tipos de application
	 * @param array $objects (array com objeto para cada nó)
	 */
	public static function createBox($objects, $id = null)
	{
		$htmlOut = "<select name='application_id' id='application_id' size='3'  style='margin: 5px!important;'>";
		foreach($objects as $object)
		{
			if($object->getId() == $id)
				$htmlOut.= "<option selected='true' value='{$object->getId()}'>";
			else
				$htmlOut.= "<option value='{$object->getId()}'>";
				
			$htmlOut.= "{$object->getName()}</option>";
		}
		return ($htmlOut."</select>");
	}
}
?>