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
		
		$html = "<ul id='breadCrumb'>";
		$html.= "<li><a href='".baseUrl."admin/'>Início</a></li>";
		switch($data)
		{
			case "index":
			break;
			
			case "flow":
				$html.= "<li><a href='".baseUrl."admin/flow'>Fluxo</a></li>";
			break;
			
			case "product":
				$html.= "<li><a href='".baseUrl."admin/product'>Produto</a></li>";
			break;
			
			case "client":
				$html.= "<li><a href='".baseUrl."admin/client'>Cliente</a></li>";
			break;
		}
		$html.= "</ul>";
		$html.= "<br style='clear:both;' />";
		echo $html;		
	}
	
}
?>