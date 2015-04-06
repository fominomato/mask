<?php 
/**
 * Classe para retornar  e renderizar a arvore de checkbox
 * atraves de um array simples.
 * Ex.: utilizando string ao inves de inteiros
 * 						[0] = Casa
 * 							[0] = Quarto
 * 								[0] = Cama
 * 								[1] = Armario
 * 							[1] = Banheiro
 * 						[1] = Carro
 * 							[0] = Porta
 *  
 * @author guarient
 *
 */
Class App_Plugins_Boxtree_BoxTree 
{

	private $hmlUlTree;
	private $htmlLi;
	private $htmlUl;
	private $htmlClUl;
	private $htmlClLi;
	private $htmlInput;
	
	function __construct()
	{
		$this->htmlUlTree 	= $hmlUlTree	= "<ul id='tree6' class='checkboxTree'>";
		$this->htmlLi 		= $htmlLi		= "<li style='clear:left;'>";
		$this->htmlUl		= $htmlUl		= "<ul>";
		$this->htmlClUl		= $htmlClUl		= "</ul>";
		$this->htmlClLi 	= $htmlClLi		= "</li>";
	}
	
	/**
	 * Metodo para gerar a confusão para a renderização da arvore de checkbox
	 * @param array  $dados ->array simples com os id dos componentes e suas chaves
	 * Ex.: utilizando string ao inves de inteiros
	 * 						[0] = Casa
	 * 							[0] = Quarto
	 * 								[0] = Cama
	 * 								[1] = Armario
	 * 							[1] = Banheiro
	 * 						[1] = Carro
	 * 							[0] = Porta
	 * @param $html
	 * @return $html
	 */
	function decompoeArray ($dados, $strNm, $cmps = null, $html = null)
	{

		if(is_array($dados))
		{				
			$html.= $this->htmlUl;			
			for($i=0; $i < count($dados); $i++):
				
				$check = "";
				if($cmps["{$strNm}"] == $dados[$i])
					$check = "checked='true'";
			
				$html.= "<li> <input {$check} type='radio' id='{$strNm}{$dados[$i]}' name='{$strNm}' value='{$dados[$i]}'>".$this->find($dados[$i]);
				$html.= self::addContent($strNm, $dados[$i]);
					
				$html = self::decompoeArray($this->getDependente($dados[$i]), $strNm, $cmps, $html);
				$html.= "</li>";
			endfor;
			$html.= "</ul>";
		}
		return $html;
	}
	
	/**
	 * metodo para gerar dinamicamente o conteudo adicional
	 * @param string $strName
	 * @param int $id
	 */
	function addContent($strName, $id = null)
	{
		$html = "";
		$strValid	= substr($strName, 0, 4);
		if(!Zend_Auth::getInstance()->getIdentity())
			return false;
		$profile	= Zend_Auth::getInstance()->getIdentity()->getRoleId();

		switch($strValid)
		{
			case "prod":
				if(strtolower($profile) == 1)
				{
					$html.= "<a href='#delete' title='Remover Produto' alt='Remover Produto' onClick='removeProduct({$id})' class='remove'>&nbsp;</a>";
					if(($flows = $this->getFlow($id)) != false)
						$html.= $this->renderFlows($flows);
				}
			break;
			
			case "comp":
				if(strtolower($profile) != 3)
				{
					$html.= "<a href='#delete' title='Remover Componente' alt='Remover Componente' onClick='removeComponent({$id})' class='remove'>&nbsp;</a>";
					if(($info = $this->getInfo($id)) != false)
						$html.= $this->renderInfo($info);
				}
			break;
		}
		return $html;		
	}
	
}
