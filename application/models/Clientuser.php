<?php
/**
 * Arquivo de modelo para o mapeamento da tabela client_user 
 * @author guarient
 *
 */
class Application_Model_Clientuser
{
    protected $client;
    protected $user;
 
    public function getUser()
    {
        return $this->user;
    }   
     
    public function getClient()
    {
        return $this->client;
    }
    

	public function setUser($user)
    {
        $this->user = new Application_Model_User();
        $mapper = new Application_Model_UserMapper();
        return $mapper->find($user, $this->user);
    }

    public function setClient($client)
    {
        $this->client = new Application_Model_Client();
        $mapper = new Application_Model_ClientMapper();
        return $mapper->find($client, $this->client);
    }
}