<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
define(errorDpl, "<div class='error'>Erro: Registro em duplicidade</div>");
class Application_Model_CommandProductMapper
{
	//Application_Model_DbTable_Flow
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_DbTable_CommandProduct();
    }

 
    public function save($flow)
    {
    	try{
	        $data = array(
	            'product_id'  		=> $flow['product_id'],
	        	'command_flow_id' 	=> $flow['command_flow_id']
	        );
			return $this->db->insert($data);
    	}catch(Exception $e)
    	{
    		if(strstr(($message = $e->getMessage()), "Duplicate"))
    			return errorDpl;
    		return $message;
    	}
    }
    
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de flow
     */
    public function fetchAll($data=null)
    {
    	try{
    		
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(true);
			if($data['product_id'] > 0)
				$select->where("product_id = ?", $data['product_id']);
			$result = $this->db->fetchAll($select);
			if(!$result)
				return false;
				
	        foreach ($result as $row)
	        { 
		        $flow   	= new Application_Model_CommandProduct();
		        $flow->setProduct($row->product_id);
		        $flow->setCommand($row->command_flow_id);
				$entries[]	= $flow;
	        }
	        return $entries;
    	}catch(Exception $e){
        	echo "Erro, pesquisa de comandos: ".$e->getMessage();
        	exit();
        }
    }
    
    /**
     * Metodo para remover item da tabela
     * @param $flow_id
     */
    public function remove($data)
    {
		$where = $this->db->getAdapter()
									->quoteInto("command_flow_id = {$data['command_flow_id']} AND product_id = ?", $data['product_id']);
		return $this->db->delete($where);
    }
}
