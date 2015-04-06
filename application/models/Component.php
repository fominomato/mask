<?php
/**
 * Arquivo de modelo para o mapeamento da tabela Component 
 * @author guarient
 *
 */
class Application_Model_Component
{
    protected $title;
    protected $id;
    protected $component_component_id;
    protected $product;
    protected $server;
    protected $client;
    
     /**
     * Metodo para retornar um objeto Application_Model_Product
     */
    public function getProduct()
    {
        return $this->product;
    }   
    
    public function getId()
    {
        return $this->id;
    }

    public function getComponentId()
    {
        return $this->component_component_id;
    }    

    public function getName()
    {
        return $this->title;
    }

    
    public function setName($title)
    {
        $this->title = $title;
    }

    /**
     * Metodo para setar um objeto Application_Model_Product
     * @param string $product_id
     * @return Application_Model_Product
     */
	public function setProduct($product)
    {
		$mapper			= new Application_Model_ProductMapper();
		$this->product	= new Application_Model_Product();
		return $mapper->find($product, $this->product);
    }

    public function setId($id)
    {
        $this->id = $id;
    } 
 
    public function setComponentId($component_component_id)
    {
		$this->component_component_id = $component_component_id;
    }

    /**
	 * @return the $server
	 */
	public function getServer() {
		return $this->server;
	}

	/**
	 * @return the $client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * @param $server the $server to set
	 */
	public function setServer($server) {
		$mapper = new Application_Model_ServerMapper();
		$this->server = new Application_Model_Server();
		return $mapper->find($server, $this->server);
	}

	/**
	 * @param $client the $client to set
	 */
	public function setClient($client) {
		$mapper			= new Application_Model_ClientMapper();
		$this->client	= new Application_Model_Client();
		return $mapper->find($client, $this->client);
	}

 }