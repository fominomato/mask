<?php
/**
 * Arquivo para apresentar um option box para tipo de fluxo
 * @author guarient
 *
 */

class Zend_View_Helper_Profile extends Zend_View_Helper_Abstract
{

	protected $data;
	
	/**
	 * Metodo para selecionar todos fluxos
	 * @param int $data
	 */
	public function Profile ($data=null, $user)
	{
		$mapper	= new Application_Model_ProfileMapper();
		$lsObj	= $mapper->fetchAll();
		return self::createBox($lsObj, $user, $data);	
	}
	
	/**
	 * Metodo para criar o box de tipos de fluxos
	 * @param array $object (array com objeto para cada nó)
	 */
	public static function createBox($obejcts, $user, $data = null)
	{
		$htmlOut = "";
		$htmlOut.= "<select name='profile_id{$user}' class='selectadmin' id='profile_id{$user}' size='3'>";
		if(count($obejcts) > 0)
		{
			foreach($obejcts as $object)
			{
				if($object->profile_id == $data)
					$htmlOut.= "<option selected='true' value='{$object->profile_id}'>{$object->title}</option>";
				else
					$htmlOut.= "<option value='{$object->profile_id}'>{$object->title}</option>";
			}
		}
		else
			$htmlOut.= "<option value=''>Não existe Parametros</option>";
		return ($htmlOut."</select>");
	}
}
?>