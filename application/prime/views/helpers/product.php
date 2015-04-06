<?php
/**
 * Arquivo para processar um option box para Product
 * @author guarient
 *
 */

class Zend_View_Helper_Product extends Zend_View_Helper_Abstract
{

	/**
	 * Metodo para selecionar todos servidores
	 * @param array $data
	 */
	public function product($data = null)
	{
		$productMapper	= new Application_Model_ProductMapper();
		$lsProduct		= $productMapper->fetchAll();

		if($data){
			$product_id =  $data->getProduct()->getId();
			$id			=  $data->getId();
		}
			
		return self::createBox($lsProduct, $product_id , $id);	
	}
	
	/**
	 * Metodo para criar o box de produtos
	 * @param array $products (array com objeto para cada nó)
	 */
	public static function createBox($products, $product_id = null, $component_id =  null)
	{
		$htmlOut = "<select class='floatleft' name='product_id' id='product_id' size='3' onChange='lnProdComp({$component_id})'>";
		$htmlOut.= "<option selected='true' value=''>Escolha um Produto</option>";
		foreach($products as $product)
		{
			if($product->getId() == $product_id)
				$htmlOut.= "<option selected='true' value='{$product->getId()}'>{$product->getName()}</option>";
			else
				$htmlOut.= "<option value='{$product->getId()}'>{$product->getName()}</option>";
		}

		return ($htmlOut."</select>");
	}
}
?>