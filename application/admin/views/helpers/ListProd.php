<?php
/**
 * Arquivo retornar uma lista de produtos com seus respectivos fluxos associados
 * @author guarient
 *
 */

class Zend_View_Helper_ListProd extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para retornar a arvore de produto 
	 * @param int $id
	 */
	public function ListProd()
	{
		$prodMapper	= new Application_Model_ProductMapper();		
		$product	= $prodMapper->getAllRoot(array("product_product_id" => "0"));
		if($product)
			return self::createList($product);
		return false;
	}
	
	/**
	 * Metodo para criar o html da lista
	 * @param array $servers (array com objeto para cada nó)
	 */
	public static function createList($object)
	{
		$html		= " ";
		$prodMapper	= new Application_Model_ProductMapper();
		$rsOut		= array();
		$a = 1;
		foreach($object as $prod)
		{
			$color 		= "border: 0px; border-bottom: 1px solid #BCD2EE;";
			$html	   .= "<tr><td colspan=2 style='{$color}'><b>".strtoupper($prod->getName())."</b></td></tr>";
			$subProds	= $prodMapper->fetchall(array("product_product_id" => $prod->getId()));
			if(is_array($subProds))
			{
				foreach($subProds as $sub)
					$html	.= self::getSubs($sub, "&nbsp;", "", $color);
			}
			$html	   .= "<tr><td colspan='2' style='height: 5px;'></td></tr>";
			$a++;
		}
		return $html;
	}
	
	/**
	 * Metodo para recuperar subprodutos
	 * @param string $product
	 * @param string $tab
	 * @param string $color
	 */
	public static function getSubs ($product, $tab = null, $html = null, $color = null)
	{
		$prodMapper	= new Application_Model_ProductMapper();
		$subProds	= $prodMapper->fetchall(array("product_product_id" => $product->getId()));
		$rsTab		= $tab.$tab;
		$htmlOpen	= "<tr><td style='{$color}border-left: 1px solid #BCD2EE;'>";
		$htmlClose	= "</td></tr>";
		
		if(!($rsHtml = self::getFlow($product, $color)))
			$html.= "<tr><td colspan='2'style='{$color} border-left: 1px solid #BCD2EE; border-right: 1px solid #BCD2EE;'>".$rsTab.$product->getName().$htmlClose;
		else 
			$html.= $htmlOpen.$rsTab.$product->getName().$rsHtml."</td> ";
		
		if(is_array($subProds))
		{
			foreach($subProds as $sub):
				$html = self::getSubs($sub, $rsTab, $html, $color);
			endforeach;
			return  $html;
		}
		return $html;
	} 
	
	
	public static function getFlow($product, $color)
	{
		$cmdprodMapper	= new Application_Model_CommandProductMapper();
		$rsOut			= $cmdprodMapper->fetchAll(array("product_id" => $product->getId()));
		$html 			= "<td style='{$color} border-right: 1px solid #BCD2EE;'>";
		$html		   .= " <ul style='list-style-type: none;'>";
		if(is_array($rsOut))
		{
			foreach($rsOut as $cmd)
				$html.= "
				<li>
				".strtoupper($cmd->getCommand()->getFlowCommand()->getName()).
				"
					<input type='image' onClick='removeAssocFlow({$product->getId()}, {$cmd->getCommand()->getId()});' title='Remover Associação' alt='Remover Associação' src='/image/remove.png'>
				</li>";
			return $html."</ul></td></tr>";
		}
		return false;
	}
	
}
?>