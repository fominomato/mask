<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_TypeMapper
{
	//Application_Model_DbTable_Type
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_DbTable_Type();
    }

 
    public function save(Application_Model_Type $type)
    {
        $data = array(
            'title'  	=> $type->getName()
        );
  		
        $id = $type->getId();
        if (null == $id) {
            return $this->db->insert($data);
        } else {
            $this->db->update($data, array('type_id = ?' => $id));
            return $id;
        }
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
			
			if($data['type_id'])
				$select->where("type_id = {$data['type_id']}");
			
			$result = $this->db->fetchAll($select);
		                
	        $entries   = array();
	        foreach ($result as $row) 
	        {
	            $entry = new Application_Model_Type();
	            self::setObject($row, $entry);
	            $entries[] = $entry;
	        }

    	}
    	catch (Exception $e)
    	{
    		echo "Error: get all packaege: ".$e->getMessage();
    		exit();
    	}
        return $entries;
    }
    
    
    function setObject($row, Application_Model_Type $type)
    {
        $type->setId($row->type_id);
    	$type->setName($row->title);
    }
    
    /**
     * Metodo para remover item da tabela
     * @param $type_id
     */
    public function remove($type_id)
    {
		$where = $this->db->getAdapter()->quoteInto('type_id_id = ?', $type_id);
		return $this->db->delete($where);
    }
}
