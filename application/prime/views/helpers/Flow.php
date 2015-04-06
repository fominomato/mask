<?php
/**
 * Arquivo para apresentar um option box para tipo de fluxo
 * @author guarient
 *
 */

class Zend_View_Helper_Flow extends Zend_View_Helper_Abstract
{

	protected $data;
	
	/**
	 * Metodo para selecionar todos fluxos
	 * @param int $data
	 */
	public function flow ($data=null)
	{
		$flowMapper	= new Application_Model_FlowMapper();
		$lsObj		= $flowMapper->getAllFlow();

		return self::createBox($lsObj, $data);	
	}
	
	/**
	 * Metodo para criar o box de tipos de fluxos
	 * @param array $object (array com objeto para cada nó)
	 */
	public static function createBox($obejcts, $id = null)
	{

		$htmlOut = "<select name='flow_id' id='flow_id' size='3' class='FlowId' onChange='listCommand()'>";
		$htmlOut.= "<option value='' selected='true'>Escolha um Fluxo</option>";
		if(count($obejcts) > 0)
		{
			foreach($obejcts as $object)
			{
				if($object->getId() == $id)
					$htmlOut.= "<option selected='true' value='{$object->getId()}'>{$object->getFlowCommand()->getName()}</option>";
				else
					$htmlOut.= "<option value='{$object->getId()}'>{$object->getFlowCommand()->getName()}</option>";
			}
		}
		else
			$htmlOut.= "<option value=''>Não existe Parametros</option>";
		
		return ($htmlOut."</select>");
	}
}
?>