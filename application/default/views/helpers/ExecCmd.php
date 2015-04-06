<?php
/**
 * Arquivo para processar comandos
 * @author guarient
 *
 */

class Zend_View_Helper_ExecCmd extends Zend_View_Helper_Abstract
{
	protected $log;
	
	/**
	 * Metodo para envio de comando e resposta
	 * @param string $server
	 * @param int $port
	 * @param string $cmd
	 * @param string $comp
	 */
	public function ExecCmd($server, $port, $cmd, $cmd_id=null, $comp=null)
	{
		switch(strtolower(PHP_OS))
		{
			case "linux":
				return self::ExecLinux($server, $port, $cmd, $cmd_id, $comp);
			break;
			
			default:
				return self::ExecLinux($server, $port, $cmd, $cmd_id, $comp);
			break;
		}
	}
	
	/**
	 * Metodo para execução de comando em linux
	 * @param string $server
	 * @param int $port
	 * @param string $cmd
	 * @param string $comp
	 * @return array
	 */
	public function ExecLinux($server, $port, $cmd, $cmd_id=null, $comp=null)
	{
		$cmdRows	= array();
		$shell		= new App_Plugins_Socket_Connection();
		$conn		= $shell->connection($server, $port);
		
		if($cmd_id)
		{
			$mapper		= new Application_Model_ArgsMapper();
			$data		= $mapper->find(array('component_id'=>$comp, 'command_id'=>$cmd_id));
				
			if($data->args)
				if(strstr($cmd, "[#instancia]"))
					$cmd = str_replace("[#instancia]", $data->args, $cmd);
		}
	
		if(($error = $shell->checkErrorCon($conn)) != false){
			return $error;
		}else{
			$cmdRows[]	= $shell->execCon($cmd, $conn);
			$shell->close($conn);
			return $cmdRows;
		}
	}

}
?>