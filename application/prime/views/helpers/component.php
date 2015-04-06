<?php
/**
 * Arquivo para processar um option box para Component
 * @author guarient
 *
 */

class Zend_View_Helper_Component extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos componentes
	 * @param array $data
	 */
	public function Component($component = null)
	{
		$objcomponent			= new Application_Model_ComponentMapper();
		$lsComponent			= $objcomponent->getAllRoot();
		if($lsComponent)		
			return self::createBox($lsComponent, $component);	
	}
	
	/**
	 * Metodo para criar o box de componentes
	 * @param array $components (array com objeto para cada nó)
	 */
	public static function createBox($components, $component_id = null)
	{
		$htmlOut.= "<select name='component_id' id='component_id' size='3' style='margin: 5px!important;'>";
		foreach($components as $component)
		{
			if(($component_id) && ($component_id == $component->getId()))
				$htmlOut.= "<option value='{$component->getId()}' selected='selected'>{$component->getName()}</option>";
			else
				$htmlOut.= "<option value='{$component->getId()}'>{$component->getName()}</option>";
		}	
		return ($htmlOut."</select>");
	}
}
?>