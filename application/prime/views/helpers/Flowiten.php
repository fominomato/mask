<?php
/**
 * Arquivo para apresentação de uma lista de fluxos
 * @author guarient
 *
 */

class Zend_View_Helper_Flowiten extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos fluxos
	 * @param string $flow_id
	 */
	public function Flowiten($flow_id = null)
	{
		$flow 		= new Application_Model_Flow();
		if($flow_id)
		{
			$flowMapper	= new Application_Model_FlowMapper();
			$flowMapper->find($flow_id, $flow);
		}
		return $flow;
	}
}
?>