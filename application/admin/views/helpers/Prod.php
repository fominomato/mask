<?php
/**
 * Arquivo para processar um option box para Tree de Produto
 * @author guarient
 *
 */

class Zend_View_Helper_Prod extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para retornar a arvore de produto pais apartir de um component
	 * @param int $id
	 */
	public function Prod()
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
		$html		= "<select name='product_id' id='product_id' size='6'> ";
		$prodMapper	= new Application_Model_ProductMapper();
		$rsOut		= array();
		$a = 1;
		foreach($object as $prod)
		{
			$html	   .= " <optgroup label='{$prod->getName()}'>";
			$subProds	= $prodMapper->fetchall(array("product_product_id" => $prod->getId()));
			if(is_array($subProds))
			{
				foreach($subProds as $sub)
					$html	.= self::getSubs($sub, "&nbsp;");
			}
			$html.= " </optgroup> ";
		}
		$html.= "</select>";
		return $html;
	}
	
	/**
	 * Metodo para recuperar subprodutoa
	 * @param unknown_type $product
	 */
	public static function getSubs ($product, $tab)
	{
		$prodMapper	= new Application_Model_ProductMapper();
		$subProds	= $prodMapper->fetchall(array("product_product_id" => $product->getId()));
		$rsTab		= $tab;
		
		if(is_array($subProds))
		{
			$html	= "";
			$html  .= " <option value='{$product->getId()}'>{$rsTab}{$product->getName()}</option> ";
			$rsTab .= $tab.$tab.$tab;
			if(is_array($subProds))
				foreach($subProds as $sub)
					$html.= self::getSubs($sub, $rsTab);
			return  $html;
		}
		return " <option value='{$product->getId()}'>{$product->getName()}</option> ";
	} 
	
}
?>