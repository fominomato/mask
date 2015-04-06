<?php
/**
 * Arquivo para apresentar um option box para tipo de fluxo
 * @author guarient
 *
 */

class Zend_View_Helper_Client extends Zend_View_Helper_Abstract
{

	protected $data;
	
	/**
	 * Metodo para selecionar todos fluxos
	 * @param int $data
	 */
	public function Client ($data=null, $user)
	{
		$mapper	= new Application_Model_ClientMapper();
		$lsObj		= $mapper->fetchAll();

		return self::createBox($lsObj, $user, $data);	
	}
	
	/**
	 * Metodo para criar o box de tipos de fluxos
	 * @param array $object (array com objeto para cada nó)
	 */
	public static function createBox($obejcts, $user, $data = null)
	{
		$htmlOut = "";
		$htmlOut.= "<select name='client_id{$user}' id='client_id{$user}' class='selectadmin' size='3' MULTIPLE>";
		if(count($obejcts) > 0)
		{
			foreach($obejcts as $object)
			{
				$a = 0;
				foreach($data as $client)
				{
					if($object->getId() == $client->getId())
					{
						$a = 1;
						$htmlOut.= "<option selected='true' value='{$object->getId()}'>{$object->getName()}</option>";
					}
				}
				if($a == 0)
					$htmlOut.= "<option value='{$object->getId()}'>{$object->getName()}</option>";
			}
		}
		else
			$htmlOut.= "<option value=''>Não existe Parametros</option>";
		return ($htmlOut."</select>");
	}
}
?>