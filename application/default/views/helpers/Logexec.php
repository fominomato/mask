<?php
/**
 * Arquivo para armazenar log de comandos
 * @author guarient
 *
 */
ini_set("display_errors", 1);
define(actionCommand, 1);
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
	public function Logexec($lines, $component_id, $command_id, $client, $process)
	{
		try{
			if(is_array($lines))
			{
				foreach($lines as $line):
					if(is_array($line))
					{
						foreach($line as $row)
							if(is_array($row))
								$text.= implode("\n\r", $row);
							else
								$text.= $row."\n\r";
					}
					else{
						$text = $line."\n\r";	
					}
					$text.="\n\r";//forçando pular uma linha apos final de um fluxo
				endforeach;
			}
			else
				$text = $lines."\n\r";
			
			$path = self::createLog($text, $client, $process);
			if($path){
				self::save($path, $component_id, $command_id);
				return $path;
			}
			return false;
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
	public static function save($data, $component_id, $command_id)
	{
		$log = array(
			"object_id" => $component_id,
			"command_id"=> $command_id,
			"value"		=> $data,
			"action_id"	=> actionCommand
		);
		$logMapper = new Application_Model_ActionlogMapper();
		return $logMapper->save($log);
	}
	
	/**
	 * Metodo para criar arquivo txt de log para execução
	 * @param string $data
	 */
	static function createLog($data=null, $client, $process)
	{
		$time		= date(formatbr);
		$client 	= self::removeAcento($client);
		$process	= self::removeAcento($process);

		$address	= rootPath.$client;
		$oldumask	= umask(0); 
		@mkdir($address, 0755, 1);
		@umask($oldumask);

		$address.="/{$process}";
		$oldumask	= umask(0);
		@mkdir($address, 0755, 1);
		@umask($oldumask);

		chdir($address);
		$fHand		= fopen("log-{$time}.txt", "a");
		if(strlen(trim($data)) < 2){
			fwrite($fHand, "Não foi possível se conectar ao servidor remoto ,\r\n verifique se o Snag esta habilitado e e conectado!");
		}else{
			fwrite($fHand, $data);
		}
		fclose($fHand);
		if($fHand)
			return "tmp/{$client}/{$process}/log-{$time}.txt";
		return false;
	}
	
	static function removeAcento($string)
	{
		$acentos= array("á","à","â","ã");
		$words	= array("a","a","a","a");
		$string =  str_replace($acentos, $words, $string);
		
		$acentos= array("é","è");
		$words	= array("e","e");
		$string =  str_replace($acentos, $words, $string);
		
		$acentos= array("ç");
		$words	= array("c");
		$string =  str_replace($acentos, $words, $string);
		
		$acentos= array("ó","õ","ò");
		$words	= array("o","o","o");
		$string =  str_replace($acentos, $words, $string);
		
		$acentos= array("ú","ü","ù");
		$words	= array("u","u","u");
		$string =  str_replace($acentos, $words, $string);
		return strtolower($string);
	}
}
?>