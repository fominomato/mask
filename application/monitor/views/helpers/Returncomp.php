<?php
/**
 * Arquivo para processar um option box para ambient
 * @author guarient
 *
 */

class Zend_View_Helper_Returncomp extends Zend_View_Helper_Abstract
{

	public function Returncomp($server)
	{
		$mapper = new Application_Model_ComponentMapper();
		return $mapper->fetchAll(array("server_id"=>$server));
	}
	
}
?>

