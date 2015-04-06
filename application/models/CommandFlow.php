<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Command 
 * @author guarient
 *
 */
class Application_Model_CommandFlow
{
    protected $id;
    protected $command; 
    protected $flow;
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $command
	 */
	public function getCommand() {
		return $this->command;
	}

	/**
	 * @return the $flow
	 */
	public function getFlow() {
		return $this->flow;
	}

	/**
	 * @param $id the $id to set
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param $command the $command to set
	 */
	public function setCommand($command) {
		$this->command	= new Application_Model_Command();
		$mapper			= new Application_Model_FlowMapper();
		return $mapper->findCommand($command, $this->command);
	}

	/**
	 * @param $flow the $flow to set
	 */
	public function setFlow($flow) {
		$this->flow	= new Application_Model_FlowCommand();
		$mapper		= new Application_Model_FlowMapper();
		return $mapper->findFlow($flow, $this->flow);
	}
 
}