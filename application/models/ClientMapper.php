<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */

class Application_Model_ClientMapper
{
    protected $db;
 
	public function __construct()
    {
        $this->db = new Application_Model_Dbtable_Client;
    }
 
    public function save(Application_Model_Client $client)
    {
        $data = array(
            'name'  => $client->getName(),
            'site'	=> $client->getSite()
        );
  		
        $id = $client->getId();
        if (null == $id) {
            return $this->db->insert($data);
        } else {
           return $this->db->update($data, array('client_id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Client $client)
    {
        $result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $client->setId($row->client_id);
        $client->setName($row->name);
        $client->setEmail($row->email);
        $client->setSite($row->site);
    }
 
 
    public function findbyId($id, Application_Model_Client $client)
    {
        $result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $client->setId($row->client_id);
        $client->setName($row->name);
        $client->setSite($row->site);
    }
    
	/**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de client
     */
    public function fetchAll()
    {
    	try{
	    	$select =  $this->db->select();
	    	$select->order("client_id DESC");
	    	
	        $resultSet = $this->db->fetchAll($select);
	        foreach ($resultSet as $row) {
	            $entry = new Application_Model_Client();
	            $entry->setId($row->client_id);
	            $entry->setName($row->name);
	            $entry->setEmail($row->email);
	            $entry->setSite($row->site);
	            $entries[] = $entry;
	        }
	        return $entries;
    	}catch(Exception $e){
    		echo $e->getMessage();
    		exit();
    	}
    }
    
	/**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de client
     */
    public function listAll()
    {
    	try{
	    	$select =  $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
			$select->setIntegrityCheck(false);
	    	$select->order("client_id DESC");
	        return $this->db->fetchAll($select);    	
    	}catch(Exception $e){
    		echo $e->getMessage();
    		exit();
    	}
    }    
    
    /**
     * Metodo para remover item da tabela
     * @param $client_id
     */
    public function remove($client_id)
    {
		$where = $this->db->getAdapter()->quoteInto('client_id = ?', $client_id);
		return $this->db->delete($where);
    }
}
