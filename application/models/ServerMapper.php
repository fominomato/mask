<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */

define(Error, "Erro: houve um erro no processamento desta requisição.");

class Application_Model_ServerMapper
{
    protected $db;
    protected $client;
    
    public function __construct()
    {
    	$this->client	= new Zend_Session_Namespace('client');
    	$this->db		= new Application_Model_DbTable_Server;
    }
 
    /**
     * Metodo para armazenar um servidor
     * @param array $server
     * @return mixed|int||false
     */
    public function save($data)
    {
    	$server['hostname'] = trim($data['hostname']);
    	$server['address']  = trim($data['address']);
    	$server['port']		= trim($data['port']);
    	$server['client_id']= $this->client->client_id;
    	
        $id = $data['server_id'];
        if (null == $id) {
            return $this->db->insert($server);
        }
        return $this->db->update($server, array('server_id = ?' => $id));
    }
 
    public function find($id, Application_Model_Server $server)
    {
    	$result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $server->setId($row->server_id);
	    $server->setHostname($row->hostname);
        $server->setAddress($row->address);
    	$server->setPort($row->port);
    }

 
    public function findbyId($id)
    {
    	$component = new Application_Model_Server();
    	$result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $component->setId($row->server_id)
	                  ->setAddress($row->address)
    	              ->setPort($row->port);
    	return $component;
    }
        
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de server
     */
    public function fetchAll()
    { 
		$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		                	->setIntegrityCheck(false);
		                	
		if($this->client)
			$select->where("client_id = ?", $this->client->client_id);
			
		$result = $this->db->fetchAll($select);
        foreach ($result as $row) {
            $entry = new Application_Model_Server();
            $entry->setId($row->server_id);
            $entry->setAddress($row->address);
            $entry->setHostname($row->hostname);
            $entry->setPort($row->port);
           	$entries[] = $entry;
        }
        return $entries;
    }
    
    /**
     * Metodo para remover item da tabela
     * @param int $server
     */
    public function remove($server)
    {
    	try{
		$where = $this->db->getAdapter()->quoteInto('server_id = ?', $server);
		if($this->db->delete($where) > 0)
			return false;
		return Error;
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }
}
