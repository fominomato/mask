<?php
/**
 * Arquivo de modelo para o mapeamento da tabela CommandProduct 
 * @author guarient
 *
 */
class Application_Model_CommandProduct
{
    protected $product;
    protected $command;
    protected $type;
    
    /**
	 * @return the $productId
	 */
	public function getProduct() {
		return $this->product;
	}

	/**
	 * @return the $commandFlow
	 */
	public function getCommand() {
		return $this->command;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param $productId the $type to set
	 */
	public function setType($type) {
		$this->type		= new Application_Model_Type();
		$mapper			= new Application_Model_TypeMapper();
		return $mapper->find($type, $this->type);
	}

	/**
	 * @param $productId the $productId to set
	 */
	public function setProduct($product) {
		$this->product	= new Application_Model_Product();
		$mapper			= new Application_Model_ProductMapper();
		return $mapper->find($product, $this->product);
	}

	/**
	 * @param $commandFlow the $commandFlow to set
	 */
	public function setCommand($command) {
		$this->command	= new Application_Model_Flow();
		$mapper			= new Application_Model_FlowMapper();
		return $mapper->find($command, $this->command);
	}

    
      
}