<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Product 
 * @author guarient
 *
 */
class Application_Model_Product
{
    protected $name;
    protected $productId;
    protected $id;
    
 
    public function setId($id)
    {
        $this->id =  $id;
    }
 
	public function getId()
    {
        return $this->id;
    }
 
    public function setName($name)
    {
        $this->name =  $name;
    }
 
    public function getName()
    {
        return $this->name;
    }

    /**
	 * @return the $product_id
	 */
	public function getProductId() {	
		return $this->productId;
	}

	/**
	 * @param $product_id the $product_id to set
	 */
	public function setProductId($productId) {
		$mapper			= new Application_Model_ProductMapper();
		$this->productId	= new Application_Model_Product();
		$mapper->find($productId, $this->productId);		
	}    
}