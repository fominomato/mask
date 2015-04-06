<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_ArgsMapper
{
	//Application_Model_DbTable_Args
    protected $db;


    function __construct()
    {
    	$this->db = new Application_Model_Dbtable_Args;
    }

    /**
     * Método para armazenas argumentos para um comando
     * @param array $data
     * @return mixed
     */
    public function save($data)
    {
    	try{
	        $args = array(	'args'  		=> $data['args'],
	        				'component_id'	=> $data['component_id'],
	        				'command_id'	=> $data['command_id']);
	        return $this->db->insert($args);
    	}
    	catch(Exception $e)
    	{
    		return $e->getMessage();
    	}
    }
    
    /**
     * Método para armazenas uma atualização de argumento
     * @param unknown_type $data
     */
    public function update($data)
    {
    	$args =  array("args" => $data['args']);
		return $this->db->update($args, array("component_id = ?" =>$data['component_id'], 
											  "command_id = ?" => $data['command_id']));
    }

 
    public function find($dados)
    {
    	try{
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
				                ->setIntegrityCheck(false);
				                
			$select->where("component_id = ?", $dados['component_id']);
			$select->where("command_id = ?", $dados['command_id']);
			
			$result = $this->db->fetchAll($select);
			if (0 == count($result))
	            return false;
	        return $result->current();
    	}catch(Exception $e){
    		echo $e->getMessage();
    		exit();
    	}
    }
    
    
    public function remove($data)
    {
		$where = $this->db->getAdapter()->quoteInto('component_id = ?', $data['component_id'])
										->quoteInto('command_id = ?', $data['command_id']);
		return $this->db->delete($where);
    }
    
}
?>