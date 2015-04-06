<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_ProcessMapper
{
	//Application_Model_DbTable_FlowComponent
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_DbTable_FlowComponent();
    }

 
    public function save($data)
    {
    	$insert = array(
            'type_id'  					=> $data['type_id'],
            'command_flow_id'			=> $data['flow_id'],
            'application_component_id'	=> $data['application_component_id']
        );
        
        $id = $data['flow_component_id'];        
        if ($id)
        	return $this->db->update($insert, array('flow_component_id = ?' => $id));
        return $this->db->insert($insert);
    }

 
    public function find($id, Application_Model_Process $process)
    {
    	try
    	{        
	    	$result = $this->db->find($id);
	        if (0 == count($result))
	            return false;
	        
	        $row = $result->current();
			self::setObject($row, $process);
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }
 
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de process
     */
    public function fetchAll($data=null)
    {
    	try{
	    	$db = new Application_Model_DbTable_Findprocess();
	        $select = $db->select();

			if($data['application_component_id'])
				$select->where("application_component_id = ?", $data['application_component_id']);

			if($data['client_id'])
				$select->where("client_id = ?", $data['client_id']);
				
			if($data['ambient_id'])
				$select->where("ambient_id = ?", $data['ambient_id']);
			
			if($data['application_id'])
				$select->where('application_id = ?', $data['application_id']);
				
			if($data['component_id'])
				$select->where('component_id = ?', $data['component_id']);
			
			if($data['component_component_id'])
				$select->where('component_component_id = ?', $data['component_component_id']);
			else 
				$select->where('component_component_id = ?', 0);
				
			if($data['product_id'])
				$select->where('product_id = ?', $data['product_id']);
						
	        return $db->fetchAll($select);
	    }
    	catch(Exception $e){
			echo $e->getMessage();    
			exit();		
    	}
    }
    
    
    /**
     * Metodo para setar um modelo
     * @param $process
     */
    function setObject($row, Application_Model_Process $process)
    {
    	$process->setId($row->flow_component_id);
        $process->setType($row->type_id);
        $process->setAppcom($row->application_component_id);
        $process->setFlow($row->command_flow_id);
    }
    
    /**
     * Metodo para buscar e retorno em formato array para gerar command
     * @param unknown_type $id
     */
    public function returnCmd($id)
    {
    	try{
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false)
			         		->joinUsing("Command_Flow", "command_flow_id", array("command_id"))       
			         		->joinUsing("Application_Component", "application_component_id", array("component_id"))       
			         		->join("Command", "Command.command_id = Command_Flow.command_id", array("command_line","command_id"))       
			         		->where("flow_component_id = {$id}");
							
	    	$result		= $this->db->fetchAll($select);
	        $row		= $result->current();
	        $rsOut[1]	= $row->command_line;
	        $rsOut[2]	= $row->component_id;
	        return $rsOut;
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }
    
   
    /**
     * Metodo para remover item da tabela
     * @param $process_id
     */
    public function remove($process_id)
    {
		$where = $this->db->getAdapter()->quoteInto('flow_component_id = ?', $process_id);
		return $this->db->delete($where);
    }
}
