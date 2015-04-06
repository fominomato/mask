<?php
/**
 * Arquivo para processar um option box para Component
 * @author guarient
 *
 */

class Zend_View_Helper_Listcomp extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos componentes
	 * @param array $data
	 */
	public function Listcomp($data)
	{
		$objcomponent			= new Application_Model_ComponentMapper();
		$lsComponent			= $objcomponent->fetchAll($data);
		if($lsComponent)		
			return $lsComponent;
		return false;	
	}
	
}
?>