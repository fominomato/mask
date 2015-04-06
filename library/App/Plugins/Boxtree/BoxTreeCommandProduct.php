<?php

/**
 * Renderizar box para componentes
 * @author guarient
 *
 */

Class App_Plugins_Boxtree_BoxTreeCommandProduct extends App_Plugins_Boxtree_BoxTree implements App_Plugins_Boxtree_InterfaceBoxTree
{
	 
	public function renderCheck ($dados=null)
	{
		$mapper= new Application_Model_ProductMapper(); 
		$rsIten= $mapper->getAllRoot($dados);
		$html  = self::renderComponentRoot ($rsIten, "", $dados);
		return $html;
	}
	

	public function renderComponentRoot ($rsComp, $html, $dados = null)
	{

		$html = "<ul id='tree6' class='checkboxTree'>\n";
		if(is_array($rsComp))
		{
			foreach($rsComp  as $item)
			{
				$html   .= $this->htmlUl;
				$checked = "";
				if($dados['product_id'] == $item->getId())
					$checked = "true";
								
				$html	   .= "\n<li style='float:left !important;'> <input type='radio' {$checked} id='product_id{$item->getId()}' name='product_id' value='{$item->getId()}'>".$item->getName();
				$html	   .= "\n<a href='#delete' title='Remover Produto' alt='Remover Produto' onClick='removeAssocFlow({$item->getId()})' class='remove'>&nbsp;</a>";
				
				if(($flows = self::getFlow($item->getId())) != false)
					$html.= self::renderFlows($flows);
				
				$subPro		= self::getDependente($item->getId());
				if($subPro)
					$html  .= self::decompoeArray($subPro, 'product_id', $dados);

			}
		}
		$html.="\n</ul>";
		return $html;
	}
	
	public function find ($id)
	{
		$product	= new Application_Model_Product();
		$mapper		= new Application_Model_ProductMapper();
		$mapper->find($id, $product);
		return 	$product->getName();		
	}
	
	
	public function getDependente($product_id)
	{
		if(!is_array($product_id))
		{
			$mapper		= new Application_Model_ProductMapper();
			return $mapper->getAll($product_id);
		}
		return false;
	}

	/**
	 * Metodo para buscar todos os fluxos
	 * @param int $product
	 * @return multitype:boolean || array
	 */
	public function getFlow($product)
	{
		$mapper	= new Application_Model_CommandProductMapper();
		return $mapper->fetchAll(array("product_id" => $product));
	}
	
	/**
	 * Método para renderizar os fluxos de um produto
	 * @param array $flows
	 * @return html
	 */
	public function renderFlows($flows)
	{
		$htmlOut = "<ul class='checkboxTree'>";
		$htmlOut.= "<li>Fluxos";
		$htmlOut.= "<ul class='checkboxTree'>";
		
		foreach($flows as $flow):
			$htmlOut.= "<li>";
			$htmlOut.= strtolower($flow->getCommand()->getFlowCommand()->getName());
			$htmlOut.= "<input type='image' onClick='removeAssoc({$flow->getProduct()->getId()}, {$flow->getCommand()->getId()});' title='Remover Associação' alt='Remover Associação' src='/image/remove.png'>";
			$htmlOut.= "</li>";
		endforeach;
		$htmlOut.= "</ul></li>";
		$htmlOut.= "</ul>";
		return $htmlOut;
	}
}