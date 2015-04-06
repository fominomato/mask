<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Ambient 
 * @author guarient
 *
 */
class Application_Model_Ambient
{
    protected $id;
    protected $title;
      
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $title
	 */
	public function getName() {
		return $this->title;
	}

	/**
	 * @param $id the $id to set
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param $title the $title to set
	 */
	public function setName($title) {
		$this->title = $title;
	}

}