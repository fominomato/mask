<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_AmbientMapper
{
	//Application_Model_DbTable_Ambient
    protected $db;


    function __construct()
    {
    	$this->db = new Application_Model_DbTable_Ambient();
    }
            
    public function save($ambient)
    {
        $data = array('title'  	=> $ambient['title']);
  		
        $id = $ambient['id'];
        if (null == $id)
            return $this->db->insert($ambient);
        else
           return $this->db->update($ambient, array('ambient_id = ?' => $id));
    }

 
    public function find($id, Application_Model_Ambient $ambient)
    {
    	$result = $this->db->find($id);
        if (0 == count($result))
            return false;

        $row = $result->current();
        $ambient->setId($row->ambient_id);
	    $ambient->setName($row->title);
    }
 
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de ambient
     */
    public function fetchAll($data=null)
    {
    	try
    	{
    		$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	                			->setIntegrityCheck(false);
			
			if($data['ambient_id'])
				$select->where("ambient_id = {$data['ambient_id']}");
			
			if($data['application_id'])
			{
				$select->join("Application_Component", "Application_Component.ambient_id = Ambient.ambient_id", array());
				$select->where("Application_Component.application_id = ?", $data['application_id']);
				$select->group("Ambient.ambient_id");
			}

			$result = $this->db->fetchAll($select);
		                
	        $entries   = array();
	        foreach ($result as $row) 
	        {
	            $entry = new Application_Model_Ambient();
	            self::setObject($row, $entry);
	            $entries[] = $entry;
	        }
    	}
    	catch (Exception $e)
    	{
    		echo "Error: get all ambients: ".$e->getMessage();
    		exit();
    	}
        return $entries;
    }
    
    
    
    function setObject($row, Application_Model_Ambient $ambient)
    {
        $ambient->setId($row->ambient_id);
    	$ambient->setName($row->title);
    }    
    
    /**
     * Metodo para remover item da tabela
     * @param $ambient
     */
    public function remove($ambient_id)
    {
		$where = $this->db->getAdapter()->quoteInto('ambient_id = ?', $ambient_id);
		return $this->db->delete($where);
    }
}
