<?php
/**
 * Arquivo para apresentação de um comando
 * @author guarient
 *
 */

class Zend_View_Helper_Command extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar um comando
	 * @param array
	 */
	public function Command($data)
	{
		$mapper	= new Application_Model_CommandMapper();
		$rsOut  = $mapper->find($data);
		return $rsOut->command_line; 
	}
}
?>