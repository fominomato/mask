<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Server 
 * @author guarient
 *
 */
class Application_Model_Server
{
    protected $address;
    protected $port;
    protected $server_id;
    protected $hostname;
    
    /**
	 * @return the $hostname
	 */
	public function getHostname() {
		return $this->hostname;
	}

	/**
	 * @param $hostname the $hostname to set
	 */
	public function setHostname($hostname) {
		$this->hostname = $hostname;
	}

	public function setId($server_id)
    {
        $this->server_id = $server_id;
    }
 
    public function getId()
    {
        return $this->server_id;
    }
 
    public function setAddress($address)
    {
        $this->address = $address;
    }
 
    public function getAddress()
    {
        return $this->address;
    }

 
    public function setPort($port)
    {
        $this->port = $port;
    }
 
    public function getPort()
    {
        return $this->port;
    }
}