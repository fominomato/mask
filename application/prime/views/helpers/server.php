<?php
/**
 * Arquivo para processar um option box para Server
 * @author guarient
 *
 */

class Zend_View_Helper_Server extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos servidores
	 * @param array $data
	 */
	public function Server($server=null)
	{
		$serverMapper	= new Application_Model_ServerMapper();
		$lsServer		=	$serverMapper->fetchAll();
		return self::createBox($lsServer, $server);
	}
	
	/**
	 * Metodo para criar o box de servers
	 * @param array $servers (array com objeto para cada nó)
	 */
	public static function createBox($servers, $id=null)
	{
		$htmlOut = "<select name='server_id' id='server_id' size='3' class='boxserver'>";
		$htmlOut.= " <option value='1'>Não aplicável</option> ";
		if(is_array($servers))
		{
			foreach($servers as $server){
				if($id == $server->getId())
					$htmlOut.= "<option value='{$server->getId()}' selected='true'>{$server->getHostname()}</option>";
				else	
					$htmlOut.= "<option value='{$server->getId()}'>{$server->getHostname()}</option>";
			}
		}

		return ($htmlOut."</select>");
	}
	
}
?>