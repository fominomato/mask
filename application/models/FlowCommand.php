<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Fluxo 
 * @author guarient
 *
 */
class Application_Model_FlowCommand
{
    protected $id;
	protected $name;
    
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param $id the $id to set
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
	}
}