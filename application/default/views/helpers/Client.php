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
		$lsClient		= $clientMapper->listAll();

		return self::createBox($lsClient);	
	}
	
	/**
	 * Metodo para criar o box de servers
	 * @param array $servers (array com objeto para cada nó)
	 */
	public static function createBox($clients)
	{
		$htmlOut	= "<select class='rowSpace' name='client_id[]' id='client_id' size='3' MULTIPLE>";
		$htmlOut   .= "<option value='' selected='true'>Selecione um cliente</option>";
		foreach($clients as $client)
			if(strlen($client->name) > 1)
				$htmlOut.= "<option value='{$client->client_id}'>{$client->name}</option>";

		return ($htmlOut."</select>");
	}
}
?>