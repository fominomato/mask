<?php
/**
 * Arquivo para processar comandos de monitoração
 * @author guarient
 *
 */

class Zend_View_Helper_Monitor extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo retornar dados dos comandos de monitoração
	 * @param array $data
	 */
	public function Monitor($data=null)
	{
		$monit	= new App_Plugins_Monitor_Commands();
		$mapper	= new Application_Model_MonitorMapper();
		$cmds	= $mapper->fetchAll(array("so"=>"lin"));
		foreach($cmds as $cmd)
			$rsOut[] = $monit->execute($cmd->command, $data);
		
		if(count($rsOut) > 0)
			return $rsOut;	
		return "Nenhum ambiente encontrado.";
	}
}
?>

