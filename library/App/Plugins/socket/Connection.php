<?php

/**
 * Classe para conexao e busca de dados através de socket
 */
Class App_Plugins_Socket_Connection extends App_Plugins_Telnet_Commands
{
	
	function connection($server, $port)
	{
		try{
			$fp = fsockopen($server, $port, $errno, $errstr);
			if(!$fp){
				$rsOut =  "{$errstr} ({$errno})<br />\r\n";
				echo $rsOut; 
				return $rsOut;
			}
			return $fp; 
		}catch (Exception $e)
		{
			return $e->getMessage();
		}
	}
	
	function close($con)
	{
		return fclose($con);
	}
	
}