<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */

define(insert,		"Novo registro adicionado.");
define(sccsUpdt,	"Registro Atualizado!");
define(errorUpdt,	"Erro: registro não atualizado!");

class Application_Model_ApplicationComponentMapper
{
	//Application_Model_DbTable_Application
    protected $db;
 
    public function __construct()
    {
    	$this->client	= new Zend_Session_Namespace('client');
       	$this->db		= new Application_Model_DbTable_ApplicationComponent();
    }
 
    public function save($appCom)
    {
    	$data = array(
    		"component_id"	=>"{$appCom['component_id']}",
    		"application_id"=>"{$appCom['application_id']}",
    		"ambient_id"	=>"{$appCom['ambient_id']}"
    	); 	
 	
       return $this->db->insert($data);
    }

    public function find($id, Application_Model_Application $application)
    {
        $result = $this->db->find($id);
        $row = $result->current();
        
        $application->setName($row->title);
        $application->setClient($row->client_id);
        $application->setId($row->application_id);      
    }  

    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de aplicação e component
     */
    public function fetchAll($data=null)
    {
		$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                	->setIntegrityCheck(false)
			                	->where("Application.client_id = ?", $this->client->client_id);
			                	
		$select->join("Component", "Application_Component.component_id = Component.component_id", array());
		$select->join("Application", "Application_Component.application_id = Application.application_id", array());
		
		if($data['title'])
			$select->where("upper(Application.title) like '%".strtoupper($data['client_id'])."%'");
		
		if($data['application_id'])
			$select->where("Application.application_id = ?", $data['application_id']);
					
		if($data['ambient_id'])
			$select->where("ambient_id = ?", $data['ambient_id']);

		if($data['component'])
			$select->where("upper(Component.title) like '%".strtoupper($data['component_component_id'])."%'");
						
		if($data['component_id'])
			$select->where("Component.component_id = ?", $data['component_id']);

		if(empty($data['title']) && !$data['component_id'] && $data['component_component_id'] < 1)
			$select->where("Component.component_component_id = ?", 0);
		elseif($data['component_component_id'])
			$select->where("Component.component_component_id = ?", $data['component_component_id']);
			
		$select->order(array("ambient_id", "Component.component_id", "Component.component_component_id"));

		$result 	= $this->db->fetchAll($select);        
		foreach($result as $row)
		{
        	$entry = new Application_Model_ApplicationComponent();
			$entry->setApplication($row->application_id);
        	$entry->setComponent($row->component_id);
            $entry->setAmbient($row->ambient_id);
            $entries[] = $entry;
		}
        return $entries;
    }    

    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de aplicação e component
     */
    public function fetchOne($data=null)
    {
		$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                	->setIntegrityCheck(false)
			                	->join("Application", "Application.application_id = Application_Component.application_id", array())
			                	->where("Application.client_id = ?", $this->client->client_id);
			                	
		if($data['application_id'])
			$select->where(" Application.application_id = ?", $data['application_id']);
			
		if($data['title']){
			$select->where(" upper(Application.title) like '%".strtoupper($data['client_id'])."%'");
		}
		
		if($data['ambient_id'])
			$select->where(" ambient_id = ?", $data['ambient_id']);

		if($data['component'])	{
			$select->join("Component", "component_id", array());
			$select->where(" Component.title like '%{$data['component_component_id']}%'");
		}
						
		if($data['component_id'])
			$select->where(" component_id = ?", $data['component_id']);
	
		try{
				$result 	= $this->db->fetchAll($select);
		        $row = $result->current();
		}
		catch(Exception $e){
			echo $e->getMessage();
			exit();
		}
        $entry = new Application_Model_ApplicationComponent();
		if($row)
		{
        	$entry->setApplication($row->application_id);
        	$entry->setComponent($row->component_id);
            $entry->setAmbient($row->ambient_id);
		}
        return $entry;
    }    
    
    
    /**
     * Método para retornar todos itens relacionados por um componente
     * @return array $entries
     */
    public function getbyComp($component)
    {
    	try{    	
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                	->setIntegrityCheck(false)
								->join("Component", "Component.component_component_id = Application_Component.component_id", array())
								->where("Application_Component.component_id = ?", $component)
								->where("Application.client_id = ?", $this->client->client_id)
								->group("Application_Component.component_id");
				
			$result = $this->db->fetchAll($select);
			
	        foreach ($result as $row) 
	        {
	        	$entry = new Application_Model_ApplicationComponent();
	            $entry->setApplication($row->application_id);
	            $entry->setComponent($row->component_id);
	            $entry->setAmbient($row->ambient_id);
	            $entries[] = $entry;
	        }

	        return $entries;
    	}
    	catch(Exception $e)
    	{
    		echo "Setar um objeto AppCom: ".$e->getMessage();
    		exit();
    	}	        
    }    


    /**
     * Método para retornar um apllicationComponent
     * @return array $entries
     */
    public function getAppComp($data)
    {
    	$entry = new Application_Model_ApplicationComponent();
        if($data['component_id']>0 && $data['ambient_id']>0 && $data['application_id']>0)
        	return $entry;
        
    	$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
							->join("Application", "Application.application_id = Application_Component.application_id", array())
    						->where("Application.client_id = ?", $this->client->client_id);
    	
    	if($data['component_id'])
			$select->where("component_id = ?", $data['component_id']);
		
		if($data['application_id'])
			$select->where("application_id = ?", $data['application_id']);
			
		if($data['ambient_id'])
			$select->where("ambient_id = ?", $data['ambient_id']);
			
		$result = $this->db->fetchAll($select);
		$row = $result->current();
		
        if($row)
        {
            $entry->setApplication($row->application_id);
            $entry->setComponent($row->component_id);
            $entry->setAmbient($row->ambient_id);
        }
        return $entry;
    }          
    
    /**
     * Metodo para remover item da tabela
     * @param $application
     */
    public function remove($data)
    {
		$where = $this->db->getAdapter()
						->quoteInto(" ambient_id ={$data['ambient_id']} AND application_id = {$data['application_id']} AND component_id = ?", $data['component_id']);
		return $this->db->delete($where);
    }
}
