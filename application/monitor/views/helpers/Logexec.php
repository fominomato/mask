<?php
/**
 * Arquivo para armazenar log de comandos
 * @author guarient
 *
 */
define(actionCommand, 3);
define(formatbr, "dmY-Hi");
define(rootPath, $_SERVER['DOCUMENT_ROOT'].'/tmp/');

class Zend_View_Helper_Logexec extends Zend_View_Helper_Abstract
{
	protected $log;
	
	/**
	 * Metodo para armazenamento de log
	 * @param array $lines
	 * @param int $component_id
	 */
	public function Logexec($lines)
	{
		try{
			return self::save(serialize($lines), actionCommand);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit();
		}
	}
	
	/**
	 * Metodo para chamada do armazenamento por meio de mapper 
	 * @param string data
	 * @param int $component_id
	 * @param int $command_id
	 */
	public static function save($data, $action_id)
	{
		$log = array(
			"object_id" => $action_id,
			"command_id"=> "",
			"value"		=> $data,
			"action_id"	=> actionCommand
		);
		$logMapper = new Application_Model_ActionlogMapper();
		return $logMapper->save($log);
	}
	
}
?>