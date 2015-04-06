<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_PackageMapper
{
	//Application_Model_DbTable_Package
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_DbTable_Package();
    }

 
    public function save($data)
    {
        $insert = array(
            'flow_component_id' => $data['flow_component_id'],
        	'source_path'  		=> $data['source_path'],
            'history_path' 		=> $data['history_path'],
            'deploy_path'		=> $data['deploy_path']
        );
  		
        $id = $data['package_id'];
        if (null == $id) {
            return $this->db->insert($insert);
        } else {
            $this->db->update($insert, array('package_id = ?' => $id));
            return $id;
        }
    }

 
    public function find($id, Application_Model_Package $package)
    {
    	try
    	{        
	    	$result = $this->db->find($id);
	        if (0 == count($result)) {
	            return false;
	        }
	        $row = $result->current();
	        $package->setId($row->package_id);
		    $package->setSource($row->source_path);
	    	$package->setDeploy($row->deploy_path);
	    	$package->setHistory($row->history_path);
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }
 
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de package
     */
    public function fetchAll($data=null)
    {
    	try
    	{
			$table = new Application_Model_DbTable_Package();
			 
			$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false);
			
			if($data['package_id'])
				$select->where("package_id = {$data['package_id']}");

			if($data['flow_component_id'])
				$select->where("flow_component_id = {$data['flow_component_id']}");
							
			$result = $table->fetchAll($select);
		                
	        foreach ($result as $row) 
	        {
	            $entry = new Application_Model_Package();
	            $entry->setId($row->package_id);
	            $entry->setSource($row->source_path);
	            $entry->setDeploy($row->deploy_path);
	            $entry->setHistory($row->history_path);
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
    
    /**
     * Metodo para remover item da tabela
     * @param $package
     */
    public function remove($package_id)
    {
		$where = $this->db->getAdapter()->quoteInto('package_id = ?', $package_id);
		return $this->db->delete($where);
    }
}
