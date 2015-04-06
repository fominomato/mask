<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Application 
 * @author guarient
 *
 */
class Application_Model_Application
{
    protected $name;
    protected $client;
    protected $id;
    
    public function setId($id)
    {
        $this->id = $id;
    }
 
    public function getId()
    {
        return $this->id;
    }

 
    public function getName()
    {
        return $this->name;
    }
 
    public function setName($name)
    {
        $this->name = $name;
    }
        
    /**
     * Metodo para setar um objeto Application_Model_Client
     * @param int $client_id
     * @return Application_Model_Client
     */
    public function setClient($client)
    {
    	$this->client 	= new Application_Model_Client;
    	$clie			= new Application_Model_ClientMapper();
    	$clie->findbyId($client, $this->client);       	
    }

    /**
     * Metodo para retornar um objeto Application_Model_Client
     */
    public function getClient()
    { 	
        return $this->client;
    }
    
}