<?php
/**
 * Classe para monitorar se existe a necessidade do envio de argumentos
 * @author guarient
 *
 */

class Zend_View_Helper_Argscmd extends Zend_View_Helper_Abstract
{

	protected $data;
	
	/**
	 * Metodo para busca de comandos
	 * @param string $data
	 */
	public function Argscmd ($cmd=null, $id=null, $comp=null)
	{
    	if($comp)
    	{
	    	$argsMapper	= new Application_Model_ArgsMapper();
	    	$data		= $argsMapper->find(array("component_id"=>$comp, "command_id"=>$id));
       	}
    			
		if(strstr($cmd, "[#instancia"))
			return self::createText($cmd, $id, $data);
		return false;
	}

	/**
	 * Metodo para apresentação de informação
	 * @param object $command
	 */
	function createText ($command, $id, $data=null)
	{
		$html = "<h2 class='middle width400'>{$command}</h2>";
		$html.= "<div class='fontBold width300 floatleft'>Digite os argumentos para o comando: </div>";
		$html.= "<input class='width300 border-box floatleft' type='text' name='args' id='args{$id}' maxlength='250' size='20' value='{$data->args}'>";
		$html.= "<br style='clear:both;' />";
		return $html;
	}
}
?>                                   