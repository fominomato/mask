<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_StatusMapper
{
	//Application_Model_DbTable_Status
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_Dbtable_Status();
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
			return $this->db->fetchAll();
    	}
    	catch (Exception $e)
    	{
    		echo "Error: get all packaege: ".$e->getMessage();
    		exit();
    	}
    }
    
}
