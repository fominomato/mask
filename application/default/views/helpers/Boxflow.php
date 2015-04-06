<?php
/**
 * Arquivo para apresentar um option box para tipo de fluxo
 * @author guarient
 *
 */

class Zend_View_Helper_Boxflow extends Zend_View_Helper_Abstract
{

	protected $data;
	
	/**
	 * Metodo para selecionar todos fluxos
	 * @param int $data
	 */
	public function Boxflow ($ctl, $data=null)
	{
		$flowMapper	= new Application_Model_CommandProductMapper();
		$lsObj		= $flowMapper->fetchAll(array("product_id"=>$data));
		return self::createBox($lsObj, $ctl);	
	}
	
	/**
	 * Metodo para criar o box de tipos de fluxos
	 * @param array $object (array com objeto para cada nó)
	 */
	public static function createBox($obejcts, $ctl = null)
	{
		$htmlOut = " <select name='flow_id' id='flow_id{$ctl}' onChange='$(\"#sbtEnviar{$ctl}\").show();' style='width: 140px; float: left;'> ";
		$htmlOut.= " <option value='' selected='true'> Escolha um Fluxo </option> ";
		if(count($obejcts) > 0 && $obejcts)
			foreach($obejcts as $object)
				$htmlOut.= " <option value='{$object->getCommand()->getId()}'>{$object->getCommand()->getFlowCommand()->getName()}</option>";
				
		return "{$htmlOut}</select>";
	}
}
?>