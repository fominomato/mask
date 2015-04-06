<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_ApplicationMapper
{
	//Application_Model_DbTable_Application
    protected $db;
    protected $client;
 
    public function __construct()
    {
    	$this->client	= new Zend_Session_Namespace('client');
        $this->db		= new Application_Model_DbTable_Application;
    }
 
    public function save($application)
    {
		$application['client_id']	= $this->client->client_id;
    	
    	if($application['client_id'] < 1)
    		return false;

        $data = array(
            'title'  	=> $application['name'],
            'client_id'	=> $application['client_id']
        );
        
        if(count(self::fetchAll($data)) > 0)
        	return false;
  		
        $id = $application['application_id'];
        
        if (null == $id)
            return $this->db->insert($data);
       	return $this->db->update($data, array('application_id = ?' => $id));
    }

 
    public function find($id, Application_Model_Application $application)
    {
    	$result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $application->setId($row->application_id);
	    $application->setName($row->title);
    	$application->setClient($row->client_id);
    }
 
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de aplicação
     */
    public function fetchAll($data=null)
    {
		$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		if($data['title'])
			$select->where("upper(title) like '%".strtoupper($data['title'])."%'");
		$select->where("client_id = ?", $this->client->client_id);

		$result = $this->db->fetchAll($select);
        foreach ($result as $row) 
        {
        	$entry = new Application_Model_Application();
            $entry->setId($row->application_id);
            $entry->setClient($row->client_id);
            $entry->setName($row->title);
            $entries[] = $entry;
        }

        return $entries;
    }

    
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de aplicação
     */
    public function fetchforBox($data=null)
    {
		$select = $this->db->select();
		$select->where("client_id = ?", $this->client->client_id);

		if($data['name'])
			$select->where("title like '{$data['name']}'");

		$result = $this->db->fetchAll($select);
        foreach ($result as $row) 
        {
            $entry = new Application_Model_Application();
            $entry->setId($row->application_id);
            $entry->setName($row->title);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    public function getAppCom($data)
    {
		$table = new Application_Model_DbTable_ApplicationComponent();
		 
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		                ->setIntegrityCheck(false);
			
		if(!$data['application_component_id']){
			$select->where("Application.client_id = ?", $this->client->client_id);
			
			$select->joinLeft('Application',
			              'application_component.application_id = Application.application_id', array());
			
			if($data['component_id'])
				$select->where(" application_component.component_id = ?", $data['component_id']);
			
			if($data['application_id'])
				$select->where(" application.application_id = ?", $data['application_id']);
		}
		else
			$select->where("application_component_id = ?", $data['application_component_id']);
			
		$result = $table->fetchAll($select);
		
		$entries   = array();

        foreach ($result as $row) {
            $entry = new Application_Model_ApplicationComponent();
            $entry->setId($row->application_component_id);
	        $entry->setServer($row->server_id);
	        $entry->setComponent($row->component_id);
	        $entry->setAmbient($row->ambient_id);
	        $entry->setApplication($row->application_id);
	        if(count($result) > 0)	
	        	return $entry; 			
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function getApplicationComponent($data)
    {
		$table = new Application_Model_DbTable_Application();
		 
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		                ->setIntegrityCheck(false);
		$select->where("Application.client_id = ?", $this->client->client_id);
				                
		$select->joinLeft('application_component',
		              'application_component.application_id = application.application_id');
		 
		if($data['component_id'])
			$select->where(" ap.component_id = ?", $data['component_id']);
		elseif($data['application_id'] > 0)
			$select->where(" a.application_id = ?", $data['application_id']);

		$result = $table->fetchAll($select);
		
		$entries   = array();
        foreach ($result as $row) {
            $entry = new Application_Model_Application();
            $entry->setId($row->application_id)
                  ->setName($row->title)
	              ->setComponent($row->component_id)
	              ->setAmbient($row->ambient_id)
	              ->setServer($row->server_id)
	              ->setClient($row->client_id);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    /**
     * Metodo para remover item da tabela
     * @param $application
     */
    public function remove($client_id)
    {
		$where = $this->db->getAdapter()->quoteInto('application_id = ?', $client_id);
		return $this->db->delete($where);
    }
}
