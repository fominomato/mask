<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_CommandFlowMapper
{
	//Application_Model_DbTable_Flow
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_DbTable_CommandFlow();
    }

 
    public function save($flow)
    {
        $data = array(
            'flow_id'  		=> $flow['flow_id'],
        	'command_id' 	=> $flow['command_id']
        );
  	
		return $this->db->insert($data);
    }
    
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de flow
     */
    public function find($data, Application_Model_CommandFlow $flowCommand)
    {
		$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		                	->setIntegrityCheck(true);
		$select->where("command_flow_id = ?", $data['command_flow_id']);

		$result = $this->db->fetchAll($select);
        $row	= $result->current();
        $flowCommand->setId($row->command_flow_id);        
        $flowCommand->setFlow($row->flow_id);
        $flowCommand->setCommand($row->command_id);
        return $flowCommand;
    }
    
    /**
     * Metodo para remover item da tabela
     * @param $flow_id
     */
    public function remove($data)
    {
		$where = $this->db->getAdapter()
									->quoteInto('command_flow_id = ?', $data['command_flow_id'])
									->quoteInto('product_id = ?', $data['product_id']);
		return $this->db->delete($where);
    }
}
