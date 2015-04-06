<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_CommandMapper
{
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_DbTable_Command();
    }
 
    public function save($command)
    {
        $data = array(
        	'command_line' 				=> $command['flow_id']
        );
  		
        $id = $command['command_id'];
        if (null == $id) {
            return $this->db->insert($data);
        } else {
            $this->db->update($data, array('command_id = ?' => $id));
            return $id;
        }
    }   

 
    public function find($id)
    {
    	$result = $this->db->find($id);
        if (0 == count($result))
            return false;
        
        return $result->current();
    }

    
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de command
     */
    public function fetchflow($data)
    {
		$db 	= new Application_Model_DbTable_CommandFlow();
		$select = $db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false);
			                
		if($data['flow_id'] > 0)
			$select->where("flow_id = {$data['flow_id']}");
		
		if($data['command_id'] > 0)
			$select->where("command_id = {$data['command_id']}");
			
		if($data['product_id'] > 0){
			$select->joinUsing("Command_Product", "command_flow_id", array());
			$select->where("Command_Product.product_id = {$data['product_id']}");
		}

		$result = $this->db->fetchAll($select);
        foreach ($result as $row) {
            $entry		= new Application_Model_Flow();
            $entry->setId($row->command_flow_id);
            $entry->setCommand($row->command_id);
            $entry->setFlowCommand($row->flow_id);
            $entries[]	= $entry;
        }
        return $entries;
    }
    
    
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de command
     */
    public function fetchAll($data)
    {
		$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		                ->setIntegrityCheck(false);
		$select->joinUsing("Command_Flow", "command_id", array());
		
		if($data['flow_id'] > 0)
			$select->where("flow_id = {$data['flow_id']}");
		
		if($data['command_id'] > 0)
			$select->where("command_id = {$data['command_id']}");
			
		if($data['product_id'] > 0){
			$select->join(array("p"=>"Command_Product"), "p.command_flow_id = Command_Flow.command_flow_id", array());
			$select->where("p.product_id = {$data['product_id']}");
		}

		$result = $this->db->fetchAll($select);
        foreach ($result as $row) {
            $entry		= new Application_Model_Command();
            $entry->setId($row->command_id);
            $entry->setName($row->command_line);
            $entries[]	= $entry;
        }
        return $entries;
    }
    
    /**
     * Metodo para remover item da tabela
     * @param $component_id
     */
    public function remove($component_id)
    {
		$where = $this->getDbTable()->getAdapter()->quoteInto('component_id = ?', $component_id);
		return $this->getDbTable()->delete($where);
    }
}
