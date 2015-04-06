<?php
/**
 * Arquivo para processar um option box para Application
 * @author guarient
 *
 */

class Zend_View_Helper_Application extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos applications
	 * @param array $data
	 */
	public function Application($data=null)
	{
		$applicationMapper	= new Application_Model_ApplicationMapper();
		$lsApplication		= $applicationMapper->fetchforBox($data);
		if(count($lsApplication) > 0)
			return self::createBox($lsApplication);	
		return false;
	}
	
	/**
	 * Metodo para criar o box de servers
	 * @param array $servers (array com objeto para cada nó)
	 */
	public static function createBox($object)
	{
		$htmlOut.="<label for='application_id'  style='width:200px; margin:0px; margin-bottom:3px;'> Escolha uma Aplicação</label>";	
		$htmlOut.= "<select name='application_id' id='application_id' size='3' onChange='pesqAmbient(this);'>"; 
		foreach($object as $iten)
			$htmlOut.= "<option value='{$iten->getId()}'>".ucfirst(strtolower($iten->getName()))."</option>"; //onClick='populateAmbient({$iten->getId()});' 

		return ($htmlOut."</select>");
	}	
}
?>