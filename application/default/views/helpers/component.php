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
	 * @param int $data (application_id)
	 * @param int $ambient (ambient_id)
	 */
	public function Component($data, $ambient=null)
	{
    	$check	= new App_Plugins_Boxtree_BoxTreeComponent();
    	return $check->renderCheck(array('application_id'=>$data, 'ambient_id'=>$ambient));
	}
	
	/**
	 * Metodo para criar o box de objectos
	 * @param array $components (array com objeto para cada nó)
	 */
	/**
	public static function createBox($object)
	{
		$htmlOut = "<label for='component_id' style='width:200px'> Escolha um Componente: </label>";
		
		$htmlOut.= "<select name='component_id' id='component_id' sixe='3'>";
		foreach($object as $iten)
		{
			$htmlOut.= "<option value='{$iten->getId()}'>{$iten->getName()}</option>";
		}	
		return ($htmlOut."</select>");
	}
	 */
}
?>