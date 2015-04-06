<?php

/**
 * Renderizar box para componentes
 * @author guarient
 *
 */

Class App_Plugins_Boxtree_BoxTreeComponent	extends App_Plugins_Boxtree_BoxTree implements App_Plugins_Boxtree_InterfaceBoxTree
{

	public function getDependente($id)
	{
		if(!is_array($id))
		{
			$mapper		= new Application_Model_ComponentMapper();
			return $mapper->getAll($id);
		}
		return false;
	}

	public  function renderCheck ($dados=null)
	{
		$mapper		= new Application_Model_ComponentMapper();
		$rsComp		= $mapper->getAllRoot($dados);
		
		if(count($rsComp) > 0)
			$html = self::renderComponentRoot ($rsComp, $html, $dados);

		return $html;
	}
	
	/**
	 * Metodo para renderizar os componentes raizes
	 * @param array $rsComp
	 * @param string $html
	 * @param mixed:array|null $dados
	 * @return string
	 */
	public function renderComponentRoot ($rsComp, $html, $dados = null)
	{
		$profile	= Zend_Auth::getInstance()->getIdentity()->getRoleId();
		
		$html.= "<ul id='treeComp' class='checkboxTree'>";
		foreach($rsComp  as $item){
			
			$checked = "";
			if($dados['component_id'] == $item->getId())
				$checked = "true";
							
			$html	.= "\n<li style='float:left !important;'> "; 
			$html	.= "\n<input type='radio' {$checked} id='component_id{$item->getId()}' name='component_id' value='{$item->getId()}'> ";
                
            if(($info = $this->getInfo($item->getId())) != false)//removido temporariamente devido a necessidade
                $html   .= "<a title='<b>Host:</b> {$info->getServer()->getHostname()} <b>ip:</b> {$info->getServer()->getAddress()}<br /><b>Produto:</b> {$info->getProduct()->getName()}'>".ucfirst(strtolower($item->getName()))."</a>";
            else
                $html   .= ucfirst(strtolower($item->getName()));                        

			if($profile == 1)
				$html	.= "<a href='#delete' onClick='removeComponent({$item->getId()})' class='remove'>&nbsp;</a> ";

			if(1==2 &&($info = $this->getInfo($item->getId())) != false)//removido temporariamente devido a necessidade
				$html.= $this->renderInfo($info);		
										
			$html	.= self::decompoeArray(self::getDependente($item->getId()), 'component_id', $dados);
			$html	.= "</li>";
		}
		$html.="</ul>";
		return $html;
	}
	
	/**
	 * Método para retornar o titulo de um component
	 * @param interger $component_id
	 * @return string
	 */
	public function find ($component_id)
	{
		$mapper		= new Application_Model_ComponentMapper();
		$rsOut		= $mapper->findbyId($component_id);
		return 	$rsOut->getName();		
	}
	

	/**
	 * Metodo para buscar informações de um componente
	 * @param int $component
	 * @return multitype:boolean || array
	 */
	public function getInfo($component)
	{
		$mapper	= new Application_Model_ComponentMapper();
		return $mapper->findbyId($component);
	}
	
	/**
	 * Método para renderizar informações
	 * @param array $infos
	 * @return html
	 */
	public function renderInfo($info)
	{
		$htmlOut = "<ul class='checkboxTree'>";
		$htmlOut.= "<li >Servidor: ";
		$htmlOut.= $info->getServer()->getHostname()."-".$info->getServer()->getAddress();
		$htmlOut.= "</li>";
		$htmlOut.= "<li>Produto: ";
		$htmlOut.= $info->getProduct()->getName();
		$htmlOut.= "</li>";
		$htmlOut.= "</ul>";
		return $htmlOut;
	}	
	
}