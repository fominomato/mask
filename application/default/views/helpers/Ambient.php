<?php
/**
 * Arquivo para processar um option box para ambient
 * @author guarient
 *
 */

class Zend_View_Helper_Ambient extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos ambients
	 * @param array $data
	 */
	public function Ambient($data=null)
	{
		$mapper		= new Application_Model_AmbientMapper();
		$lsObjects	= $mapper->fetchAll($data);
		if(count($lsObjects) > 0)
			return self::createBox($lsObjects, $data['application_id']);	
		return "Nenhum ambiente encontrado.";
	}
	
	/**
	 * Metodo para criar o box de ambient
	 * @param array $object (array com objeto para cada nó)
	 */
	public static function createBox($object, $data=null)
	{
		$htmlOut.= "<label for='ambient_id' style='width:200px; margin:0px; margin-bottom:3px;'>Escolha um Ambiente</label>";	

		$htmlOut.= "<select name='ambient_id' id='ambient_id' size='3' onChange='pesqComp(this, {$data});'>";
		foreach($object as $ambient): 
			$htmlOut.= "<option value='{$ambient->getId()}'>{$ambient->getName()}</option>";
		endforeach;
		return "{$htmlOut}</select>";
	}	
}
?>

