<?php

/**
 * Renderizar box para componentes
 * @author guarient
 *
 */

Class App_Plugins_Boxtree_BoxTreeProduct extends App_Plugins_Boxtree_BoxTree implements App_Plugins_Boxtree_InterfaceBoxTree
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
		$html	   = "<ul id='tree6' class='checkboxTree'>";
		if(is_array($rsComp))
		{
			foreach($rsComp  as $item)
			{
				$html .= $this->htmlUl;							
				$checked = "";
				if($dados['product_id'] == $item->getId())
					$checked = "true";
								
				$html	   .= "<li style='float:left !important;'>";
				if(strstr($_SERVER['REQUEST_URI'], 'admin') || $item->getProductId() != "0")
					$html	   .= "<input type='radio' {$checked} id='product_id{$item->getId()}' name='product_id' value='{$item->getId()}'>";
				
				$html	   .= $item->getName();
				if(strstr($_SERVER['REQUEST_URI'], 'admin'))
					$html	   .= "<a href='#delete' onClick='removeProduct({$item->getId()})' class='remove'>&nbsp;</a>";					
				
				$subPro		= self::getDependente($item->getId());
				if($subPro)
					$html	   .= self::decompoeArray($subPro, 'product_id', $dados);
			}
		}
		$html.="</ul>";
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
	
	function getFlow()
	{
		
	}
	
}