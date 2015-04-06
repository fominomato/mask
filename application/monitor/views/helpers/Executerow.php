<?php
/**
 * Arquivo para processar um option box para ambient
 * @author guarient
 *
 */

class Zend_View_Helper_Executerow extends Zend_View_Helper_Abstract
{

	/**
	 * 
	 * @param Application_Model_Component $component
	 */
	public function Executerow($component)
	{
		try{
			$ProdMapper = new Application_Model_CommandProductMapper();
			$cmdProd = $ProdMapper->fetchAll(array("product_id"=> $component->getProduct()->getId()));
			if(is_array($cmdProd))
				return self::validCmd($cmdProd, $component);
			return "Erro: não encontramos comandos para monitoração;";
		}catch(Exception $e){
			echo $e->getMessage();
			exit();
		}
	}
	
	/**
	 * Metodo para separar o comando para gerar comando de health
	 * @param Application_Model_CommandProduct $cmdProd
	 * @param Application_Model_Component $component
	 * 
	 * @return string
	 */
	public static function validCmd($cmdProd, Application_Model_Component $component)
	{
		if(is_array($cmdProd))
		{
			foreach($cmdProd as $cm)
			{
				$cmd = strtolower($cm->getCommand()->getCommand()->getName());
				if(strstr($cmd, "webctl"))
					if(strstr($cmd, "status"))
						return self::ExecWebctl($cm, $component);
			}
		}
		return "Erro: Comando não válido!";
	}
	
	/**
	 * Metodo para execução do comando webctl status passando argumento
	 * @param Application_Model_CommandProduct $cmd
	 * @param Application_Model_Component $component
	 */
	public static function ExecWebctl (Application_Model_CommandProduct $cmdPd, Application_Model_Component $component)
	{
		$mapper = new Application_Model_ArgsMapper();
		$arg 	= $mapper->find(array("component_id"=>$component->getId(), "command_id"=>$cmdPd->getCommand()->getCommand()->getId()));
		if($arg->args)
		{
			$cmd	= str_replace("[#instancia]", $arg->args, $cmdPd->getCommand()->getCommand()->getName());
			return App_Plugins_Monitor_Commands::execute($cmd, array("server" => $component->getServer()->getAddress(), "port"=>$component->getServer()->getPort()));
		}
		return "Não existe argumentos!";
	}
}
?>