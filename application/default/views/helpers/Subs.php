<?php
/**
 * Arquivo para apresentação de uma lista de subcomponentes
 * @author guarient
 *
 */

class Zend_View_Helper_Subs extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos subComponentes
	 * @param string $component
	 */
	public function Subs($component)
	{
		$mapper		= new Application_Model_ComponentMapper();
		$lsObjects	= $mapper->fetchAll(array("component_component_id"=> $component));
		if(is_array($lsObjects) && count($lsObjects) > 0){
			$rsOut = self::recursive($lsObjects);
		}
		
		if(is_array($rsOut) && is_array($lsObjects))
			return array_merge($lsObjects, $rsOut);
		return $lsObjects;
	}
	
	function recursive($obj)
	{
		$mapper	= new Application_Model_ComponentMapper();
		foreach($obj as $iten):
			if(($rsSubs = $mapper->fetchAll(array("component_component_id"=> $iten->getId()))) != false)
				$rsOut = self::recursive($rsSubs);
		endforeach;
		if(is_array($rsSubs))
			return array_merge($rsSubs, $rsOut);
		return $rsOut;			
	}
}
?>