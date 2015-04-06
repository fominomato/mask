<?php
/**
 * Arquivo para processar um option box para server
 * @author guarient
 *
 */

class Zend_View_Helper_Client extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos clientes
	 * @param array $data
	 */
	public function client()
	{
		$clientMapper	= new Application_Model_ClientMapper();
		$lsClient		= $clientMapper->fetchAll();

		return self::createBox($lsClient);	
	}
	
	/**
	 * Metodo para criar o box de servers
	 * @param array $servers (array com objeto para cada nó)
	 */
	public static function createBox($clients)
	{
		$htmlOut	= "<select name='client_id' id='client_id' size='3'>";
		foreach($clients as $client)
			$htmlOut.= "<option value='{$client->getId()}'>{$client->getName()}</option>";

		return ($htmlOut."</select>");
	}
}
?>