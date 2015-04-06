<?php

/**
 * Classe responsavel por verificação de erros
 * @author guarient
 *
 */

Class App_Plugins_Telnet_Error
{
	private $error;
	
	/**
	 * Método para verificar se existe erro na linha
	 * @param string $line
	 */
	static function checkError($lines)
	{
		$last = count($lines);
		$line = $lines[$last-2];
		$errors = array("unable", "allowed");
		if ($line)
			foreach($errors as $error):
				if(strstr($error , strtolower($line))){
					echo '<script>alert("Error: '.str_replace("\r\n", " ", $line).'");</script>';	
					die();	
				}
			endforeach;
	}	
	
	
	/**
	 * Método para verificar se existe erro na conexão
	 * @param string $line
	 */
	function checkErrorCon($data)
	{
		$errors = array("unable", "refused");
		if ($data)
		{
			foreach($errors as $error):
				if(strstr(strtolower($data), $error))
				{
					echo $data; 
					return $data;
				}
			endforeach;
			return false;
		}
		echo $error = "Impossível estabelecer conexão!";
		return $error;
	}		
	
	static function errorRmd($server)
	{
		$errorRmd = "Falha ao conectar ao RMD no servidor {$server}.";
		trigger_error($errorRmd, E_USER_WARNING);
		return array($errorRmd);
	}
	
	
	static function checkEnd($row)
	{
		if($row)
			return false;
		return true;	
	}
		
}