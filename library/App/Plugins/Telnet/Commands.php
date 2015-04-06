<?php

/**
 * Classe para execução de comandos de telnet
 */
define(user, 'admweb');

Class App_Plugins_Telnet_Commands extends App_Plugins_Telnet_Error
{
	protected $sec 		= 15;
	
	/**
	 * Método para executar o comando raiz antes de um fluxo
	 * @param string $cmd
	 * @param string $conn
	 */
	function execCon($cmd, $conn=null)
	{
		$cmdLine = array();
		sleep(1);
		$start = time();
		
		echo $cmd."<br />\r\n";//apresentar comando
		$cmdLine[0] = $cmd."\r\n";
		fwrite($conn, $cmd."\n");

		$i = true;
		$a = 1;
		while($i == true){
			$line = fgets($conn, 16384);
			if($line)
				echo $line."<br />";//apresentar retorno do comando
				
			ob_get_flush();	
			flush();
			
			$cmdLine[$a] = $line."\r\n";
			sleep(1);
			
			if($a > 0)
			{
				if(self::checkError($cmdLine) || strchr($cmdLine[$a-1], user)){
					$i = false;
					break;
				}
				
				if(self::checkEnd($line)){	
					$i=false;
					break;
				}
			}
			$a++; 
		}
		if(!is_array($cmdLine) || count($cmdLine) < 1)
			return array(0=>"Não retornou dados, entre em contato.");
		return $cmdLine;
	}
	
	/**
	 * Metodo para execução de comando no Windows
	 * @param string $path
	 * @param string $args
	 */
	function execWinAsync($path, $args)
	{
	    $WshShell						= new COM("WScript.Shell"); 
	    $oShellLink 					= $WshShell->CreateShortcut("temp.lnk"); 
	    $oShellLink->TargetPath 		= $path; 
	    $oShellLink->Arguments			= $args; 
	    $oShellLink->WorkingDirectory	= dirname($path); 
	    $oShellLink->WindowStyle		= 1; //apenas para setar true
	    $oShellLink->Save(); 
	    $oExec							= $WshShell->Run("temp.lnk", 7, false); 
	    unset($WshShell,$oShellLink,$oExec); 
	    unlink("temp.lnk"); 
	}
	
	/**
	 * Metodo para conexao atraves de exec universal
	 * @param $cmd
	 */
	function execCmd($cmd)
	{
		$rsOut = array();
		$teste = exec($cmd, $rsOut['lines'], $rsOut['var']);
		return $rsOut;
	}
	
	
	/**
	 * Método para executar o comando raiz antes de um fluxo
	 * @param string $cmd
	 * @param string $conn
	 */
	function execOnly($cmd, $conn=null)
	{
		$cmdLine = array();
		$start = time();
		$cmdLine[0] = $cmd."\r\n";
		fwrite($conn, $cmd."\n");

		$i = true;
		$a = 1;
		while($i == true){
			$line = fgets($conn, 16384);
			$cmdLine[$a] = $line."\r\n";
			sleep(1);
			
			if($a > 0)
			{
				if(self::checkError($cmdLine) || strchr($cmdLine[$a-1], user)){
					$i = false;
					break;
				}
				
				if(self::checkEnd($line)){	
					$i=false;
					break;
				}
			}
			$a++; 
		}
		if(!is_array($cmdLine) || count($cmdLine) < 1)
			return array(0=>"Não retornou dados, entre em contato.");
		return $cmdLine;
	}
		
}