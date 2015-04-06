<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Application 
 * @author guarient
 *
 */
class Application_Model_Package
{
    protected $source;
    protected $deploy;
    protected $history;
    protected $id;
    
	/**
	 * @return the $source
	 */
	public function getSource() {
		return $this->source;
	}

	/**
	 * @return the $deploy
	 */
	public function getDeploy() {
		return $this->deploy;
	}

	/**
	 * @return the $history
	 */
	public function getHistory() {
		return $this->history;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param $source the $source to set
	 */
	public function setSource($source) {
		$this->source = $source;
	}

	/**
	 * @param $deploy the $deploy to set
	 */
	public function setDeploy($deploy) {
		$this->deploy = $deploy;
	}

	/**
	 * @param $history the $history to set
	 */
	public function setHistory($history) {
		$this->history = $history;
	}

	/**
	 * @param $id the $id to set
	 */
	public function setId($id) {
		$this->id = $id;
	}

 


}