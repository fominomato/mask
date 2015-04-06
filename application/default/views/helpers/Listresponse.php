<?php
/**
 * Arquivo para processar um option box para Component
 * @author guarient
 *
 */

class Zend_View_Helper_Listresponse extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para retornar todos subcomponentes
	 * @param array $data (component_id, ambient_id, application_id)
	 * @param return
	 */
	public function Listresponse($data)
	{
    	$mapper	= new Application_Model_ProcessMapper();
    	return $mapper->fetchAll($data);
	}
}
?>