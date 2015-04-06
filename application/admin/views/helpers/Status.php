<?php
/**
 * Arquivo para apresentar um option box para tipo de fluxo
 * @author guarient
 *
 */

class Zend_View_Helper_Status extends Zend_View_Helper_Abstract
{
	protected $data;
	
	/**
	 * Metodo para selecionar todos fluxos
	 * @param int $data
	 */
	public function Status ($data=null, $user)
	{
		$mapper	= new Application_Model_StatusMapper();
		return self::createBox($mapper->fetchAll(), $user, $data);	
	}
	
	/**
	 * Metodo para criar o box de tipos de fluxos
	 * @param array $object (array com objeto para cada nó)
	 */
	public static function createBox($obejcts, $user, $data = null)
	{
		$htmlOut = "<select name='status_id{$user}' class='selectadmin' id='status_id{$user}' size='3'>";
		if(count($obejcts) > 0)
		{
			foreach($obejcts as $object)
			{
				if($object->status_id == $data)
					$htmlOut.= "<option selected='true' value='{$object->status_id}'>{$object->title}</option>";
				else
					$htmlOut.= "<option value='{$object->status_id}'>{$object->title}</option>";
			}
		}
		else
			$htmlOut.= "<option value=''>Não existe Parametros</option>";
		return ($htmlOut."</select>");
	}
}
?>