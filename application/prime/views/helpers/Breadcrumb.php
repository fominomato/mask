<?php
/**
 * Arquivo para apresentar um breadcrumb
 * @author guarient
 *
 */
define(baseUrl, "http://{$_SERVER['SERVER_NAME']}/");

class Zend_View_Helper_Breadcrumb extends Zend_View_Helper_Abstract
{
	/**
	 * metodo para apresentar um breadcrumb
	 * @param string $data
	 * @param unknow $extends
	 */
	public function breadcrumb($data=null, $extends=null)
	{
    	$session = new Zend_Session_Namespace('client');
				
		$html = "<ul id='breadCrumb'>";
		$html.= "<li><a href='".baseUrl."prime/'>Início</a></li>";
		switch($data)
		{
			case "fluxo":
				$html.= "<li><a href='".baseUrl."prime/flow'>Fluxo</a></li>";
				$html.= "<li>{$extends}</li>";
			break;
			
			case "component":
				$html.= "<li><a href='".baseUrl."prime/component'>Componente</a></li>";
				$html.= "<li><a href='".baseUrl."prime/component'>".strtoupper($session->client_name)."</a></li>";
				if(strlen($extends) > 0)
					$html.= "<li>{$extends}</li>";
			break;
			
			case "aplicacao":
				$html.= "<li><a href='".baseUrl."prime/appliance'>Aplicação</a></li>";
				$html.= "<li>{$extends}</li>";
			break;
			
			case "process":
				$html.= "<li><a href='".baseUrl."prime/appliance'>Aplicação</a></li>";
				$html.= "<li><a href='".baseUrl."prime/process'>Processo</a></li>";
				if(is_string($extends))
					$html.= "<li>{$extends}</li>";
				elseif($extends){
					$html.= "<li>{$extends->getApplication()->getClient()->getName()}</li>";
					$html.= "<li>{$extends->getApplication()->getName()}</li>";
					$html.= "<li>{$extends->getComponent()->getName()}</li>";
					$html.= "<li>{$extends->getServer()->getHostname()}</li>";
					$html.= "<li>{$extends->getAmbient()->getName()}</li>";
				}
			break;
		}
		$html.= "</ul>";
		$html.= "<br style='clear:both;' />";
		echo $html;		
	}
	
}
?>