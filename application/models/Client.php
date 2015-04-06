<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Client 
 * @author guarient
 *
 */
class Application_Model_Client
{
    protected $site;
    protected $name;
    protected $email;
    protected $client_id;
 
    public function getSite()
    {
        return $this->site;
    }   
     
    public function getName()
    {
        return $this->name;
    }
    
    public function getId()
    {
        return $this->client_id;
    }
    
    /**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param $email the $email to set
	 */
	public function setEmail($email) {
		$this->email = $email;
	    return $this->email;
	}

	public function setId($id)
    {
        $this->client_id = $id;
        return $this->client_id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this->name;
    }
    
    public function setSite($site)
    {
        $this->site = $site;
        return $this->site;
    }
 
}