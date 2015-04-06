<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_FlowMapper
{
	//Application_Model_DbTable_Flow
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_DbTable_CommandFlow();
    }

 
    public function save($flow, $flow_id=null)
    {

        $data = array(
            'command_id'  			=> $flow['command_id'],
        	'flow_id' 				=> $flow['flow_id']
        );
        
        if($flow_id)
        	$data['flow_id'] = $flow_id;
  		
        $id = $flow['command_flow_id'];
        if (null == $id) {
            return $this->db->insert($data);
        } else {
            $this->db->update($data, array('command_flow_id = ?' => $id));
            return $id;
        }
    }

 
    public function find($id, Application_Model_Flow $flow)
    {
    	$result = $this->db->find($id);
        if (0 == count($result))
            return false;
        
        $row = $result->current();
		self::setObject(&$row, $flow);
    }

 
    public function findFlow($id, Application_Model_FlowCommand $flowCommand)
    {
        $bd = new Application_Model_DbTable_Flow();
    	$result = $bd->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
		$flowCommand->setId($row->flow_id);
        $flowCommand->setName($row->title);  
    }

    
    public function findCommand($id, Application_Model_Command $command)
    {
        $bd = new Application_Model_DbTable_Command();
    	$result = $bd->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
		$command->setId($row->command_id);
        $command->setName($row->command_line);  
    }    
    
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de flow
     */
    public function fetchAll($data=null)
    {
		$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		                ->setIntegrityCheck(true)
						->joinUsing("Command_Flow", "flow_id", array())
		                ->joinUsing("Command_Product", "command_flow_id", array());
						
		if($data['product_id'])
			$select->where("Command_Product.product_id = {$data['product_id']}");

		$result = $this->db->fetchAll($select);
        $flow   = new Application_Model_Flow();
        foreach ($result as $row) 
        	$entries[] = self::setObject($row, $flow);
        return $entries;
    }

   /**
     * Metodo para setar um modelo
     * @param $process
     */
    function setObject($row, Application_Model_Flow $flow)
    {
		$flow->setId($row->command_flow_id);
        $flow->setCommand($row->command_id);
        $flow->setFlowCommand($row->flow_id);
		return $flow;
    }

    
    /**
     * Método para retornar todos fluxos ja cadastrados
     * @return array $entry com os objetos de flow
     */
    public function getAllFlow($data=null)
    {
    	try
    	{
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false);
			$result = $this->db->fetchAll($select);
		    foreach ($result as $row) 
	        {
	            $entry = new Application_Model_Flow();
				$entry->setId($row->command_flow_id);
		        $entry->setCommand($row->command_id); 
		        $entry->setFlowCommand($row->flow_id); 
		        $entries[] = $entry;	
	        }
    	}
    	catch (Exception $e)
    	{
    		echo "Error: get all flow: ".$e->getMessage();
    		exit();
    	}
        return $entries;
    }
    
    /**
     * Método para retornar todos fluxos ja cadastrados
     * @return array $entry com os objetos de flow
     */
    public function getFlowbyProcess($data)
    {
        $bd = new Application_Model_DbTable_CommandFlow();
		$select = $bd->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		                ->setIntegrityCheck(false);
		                
		if($data['flow_component_id'])
			$select->where("flow_component_id = ?", $data['flow_component_id']);
		                
		$result = $bd->fetchAll($select);
	                
        $entries   = array();
        foreach ($result as $row) 
        {
            $entry = new Application_Model_Flow();
			$entry->setFlowCommand($row->flow_id);
	        $entry->setCommand($row->command_id); 
	        $entries[] = $entry;	
        }
        return $entries;
    }    
    
    /**
     * Metodo para remover item da tabela
     * @param $flow_id
     */
    public function remove($flow_id)
    {
		$where = $this->db->getAdapter()->quoteInto('command_flow_id = ?', $flow_id);
		return $this->db->delete($where);
    }
}
