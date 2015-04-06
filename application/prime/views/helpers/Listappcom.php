<?php
/**
 * Arquivo para processar um option box para Component
 * @author guarient
 *
 */

class Zend_View_Helper_Listappcom extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos componentes
	 * @param array $data
	 */
	public function Listappcom($data)
	{
    	$mapper					= new Application_Model_ApplicationComponentMapper();
		$lsComponent			= $mapper->fetchAll($data);
		if($lsComponent)		
			return $lsComponent;
		return false;	
	}
	
}
?>