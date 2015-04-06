<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_MonitorMapper
{
	//Application_Model_DbTable_Monitor
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_Dbtable_Monitor();
    }

    public function find($id, Application_Model_Type $type)
    {
   
    	$result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $type->setId($row->type_id);
    	$type->setName($row->title);
    }
 
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de tipo
     */
    public function fetchAll($data=null)
    {
    	try
    	{
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false);
			
			if($data['so'])
				$select->where("so like '%{$data['so']}%'");
			
			$result = $this->db->fetchAll($select);
			if($result)
				return $result;
			return false;
    	}
    	catch (Exception $e)
    	{
    		echo "Error: get all packaege: ".$e->getMessage();
    		exit();
    	}
    }
}
