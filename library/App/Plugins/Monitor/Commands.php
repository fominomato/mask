<?php

/**
 * Classe para comandos de monitoração específicos
 * 
 */

Class App_Plugins_Monitor_Commands extends App_Plugins_Socket_Connection
{

	/**
	 * Metodo para execução do comando
	 * @param string $cmd
	 */
	function execute($cmd , $data)
	{
		$rsOut = array();
		$conn  = self::connection($data['server'], $data['port']);;
		if(is_resource($conn))
		{
			$rsOut = self::execOnly($cmd, $conn);
			self::close($conn);
			return self::display($rsOut, $cmd);	
		}
		return "Error: verifique se o status do rmd para este servidor!"; 
	}
	
	/**
	 * Metodo para apresentação dos dados na tela
	 * @param array $data
	 */
	function display($data, $cmd)
	{
		$cmd = substr($cmd, 0 ,4);
		switch($cmd)
		{
			case "free":
				$rsOut = self::renderFree($data);
			break;
			
			case "vmst":
				$rsOut = self::renderVmstat($data);
			break;
			
			default:
				$rsOut = $data[1];
			break;
		}
		return $rsOut;
	}
	
	function renderFree($data)
	{
		$rsOut = array();
		for($i=1; $i < (count($data)-1); $i++)
			$rsOut[] = preg_split("/[\s]+/", rtrim($data[$i]));
		return $rsOut;
	}
	
	function renderVmstat($data)
	{
		$rsOut = array();
		for($i=2; $i < (count($data)-1); $i++)
			$rsOut[] = preg_split("/[\s]+/", rtrim(ltrim($data[$i])));
		return $rsOut;
	}
}