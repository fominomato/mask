<?php

/**
 * Classe para conexao e busca de dados através de socket
 */
define(formatbr, "dmY-Hi");
define(rootPath, $_SERVER['DOCUMENT_ROOT'].'/tmp/');

Class App_Plugins_Proc_Proc extends App_Plugins_Telnet_Commands
{
	
	/**
	 * Metodo para execução
	 * http://php.net/manual/en/function.proc-open.php
	 * 
	 * @param string $client
	 */
	function execProc($rootCmd, $cmd)
	{
		$time = date(formatbr);
		
		$descriptorspec = array(
		   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
		   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
		);
		
		$process = proc_open($rootCmd, $descriptorspec, $pipes);
		
		if ($process) {
			// $pipes now looks like this:
			// 0 => writeable handle connected to child stdin
			// 1 => readable handle connected to child stdout
			// Any error output will be appended to /tmp/error-output.txt

			fwrite($pipes[0], $cmd);
			fclose($pipes[0]);
			
			
			while (!feof($pipes[1]))
			{
				echo fgets($pipes[1]);
			}
			fclose($pipes[1]);

			// It is important that you close any pipes before calling
			//proc_close in order to avoid a deadlock
			$return_value = proc_close($process);
			var_dump($return_value);
			exit();
			echo $return_value."\n <br />";
		}
			
	}	
	
	
}