<?php
/**
 * Arquivo para abstração de ações para rotinas de banco de dados
 */
Class App_Plugins_Ssh_Connection extends App_Plugins_Telnet_Commands
{
	protected $host			= '148.91.91.204';
	protected $user			= 'admweb';
	protected $port			= '22';
	protected $password 	= 'v1rtu0l&00Eds';
	protected $con 			= null;
	protected $shell_type	= 'xterm';
	protected $shell 		= null;
	protected $log 			= '';
	
	/**
	 * Metodo para envio de comando e resposta
	 * @param array $data
	 */
	public function __construct($rootCmd, $cmd)
	{
		$cmdLine	= "";
		$shell		= self::connection();
		$cmdLine[]	= self::execCon($rootCmd, $shell);
		$cmdLine[]	= self::execCon($cmd, $shell);
		echo "\n<br />";	
		fclose($shell);		
		return $cmdLine;
	}
	
	/**
	 * Metodo para acesso 
	 * @param array $servers (array com objeto para cada nó)
	 */
	public static function connection()
	{
		$con	= ssh2_connect(server, "22");
	    if(!$con)
	    	$this->log = "Error: Unable to connect on server.";

	    if(!ssh2_auth_password($con, user, password)) 
	    	$this->log = "Error: Permission denied.";
		
		if (!($stdio = ssh2_shell($con, 'xterm', null, 80, 24, SSH2_TERM_UNIT_CHARS))) 
			$this->log = "Error: unable apply command line!";
			
	    return $stdio;
	}

}