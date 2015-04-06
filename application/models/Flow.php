<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Fluxo 
 * @author guarient
 *
 */
class Application_Model_Flow
{
    protected $id;
	protected $command;
    protected $flowCommand;
 
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
	public function getFlowCommand() {
		return $this->flowCommand;
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
		$this->command = new Application_Model_Command();
		$fMapper = new Application_Model_FlowMapper();
		$fMapper->findCommand($command, $this->command);	
	}

	/**
	 * @param $flow the $flow to set
	 */
	public function setFlowCommand($flowCommand) {
		$this->flowCommand = new Application_Model_FlowCommand();
		$fMapper = new Application_Model_FlowMapper();
		$fMapper->findFlow($flowCommand, $this->flowCommand);			
	}


	public function getFlows($flowComponent=null)
	{
		if(empty($flowComponent))
			$flowComponent = $this->flowComponent;
			
		$fMapper = new Application_Model_FlowMapper();
		return $fMapper->fetchAll(array("flow_component_id"=>$flowComponent));		
	}
}