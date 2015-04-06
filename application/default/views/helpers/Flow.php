<?php
/**
 * Arquivo para apresentação de uma lista de fluxos
 * @author guarient
 *
 */

class Zend_View_Helper_Flow extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos fluxos
	 * @param string $product_id
	 */
	public function Flow($product_id)
	{
		$flowMapper	= new Application_Model_CommandProductMapper();
		$lsObjects	= $flowMapper->fetchAll(array("product_id"=> $product_id));
		return $lsObjects;
	}
}
?>