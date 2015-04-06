<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_ComponentMapper
{
    protected $db;
    protected $client;
 
    public function __construct()
    {
    	$this->client	= new Zend_Session_Namespace('client');
        $this->db		= new Application_Model_DbTable_Component;
    }
    
    public function validComponent($component)
    {
    	$comp	= new Application_Model_Component();
    	self::find($component['component_id'], $comp);
    	 
    	if(!$comp->getId())
    		return false;
    	return $comp;
    }
 
    /**
     * Metodo para inserir componente 
     * @param array $component
     * @return string|mixed|number
     */
    public function save($component)
    {
    	$objComp = self::validComponent($component);
    	if($component['component_id'])
    	{
    		if( $objComp == false)
    			return false;
    	}
    			
		if($component['component_id'] < 1)
        	$component['component_id'] = 0; 
        
        if($component['server_id'] < 1 || empty($component['server_id']) || !$component['server_id'])
        	$component['server_id'] = 1;
        
        $data = array(
            'title'  					=> strip_tags($component['title']),
            'server_id'					=> $component['server_id'],
        	'client_id'					=> $this->client->client_id,
        	'component_component_id'	=> $component['component_id']
        );
        
        if(!$component['component_id'] || $component['component_id'] < 1)
			return $this->db->insert($data);
        elseif(($id = $this->db->insert($data)) > 0)
        	return array("product_id" => $objComp->getProduct()->getId(), "id" => $id);
        else	        
        	return false;
    }
    

    /**
     * Metodo para update componente 
     * @param array $component
     * @return string|mixed|number
     */
    public function update($component)
    {
        $data['product_id'] = $component['product_id'];
    	if($component['component_id'])
    		if(self::validComponent($component) == false)
    			return false;
		return $this->db->update($data, array("component_id = ?" => $component['component_id']));
    }
    
    
 	/**
 	 * Metodo para busca atraves do id
 	 * @param unknown_type $id
 	 * @param Application_Model_Component $component
 	 */
	public function find($id, Application_Model_Component $component)
    {
    	$result = $this->db->find($id);
        if (0 == count($result)) {
        	return false;
        }
        $row = $result->current();
        $component->setId($row->component_id);
	    $component->setComponentId($row->component_component_id);
	    $component->setName($row->title);
	    $component->setServer($row->server_id);
	    $component->setClient($row->client_id);
	    $component->setProduct($row->product_id);
    }

    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de aplicação
     */
    public function fetchforBox($data=null)
    {
    	try {
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false)
							->joinLeft('Application_Component',
			              'Application_Component.component_id = Component.component_id');
			
			if($data['application_id'])
				$select->where('application_id = ?', $data['application_id']);
			
			$result = $this->db->fetchAll($select);
	
	        $entries   = array();
	        foreach ($result as $row) 
	        {
	            $entry = new Application_Model_Component();
	            $entry->setId($row->component_id);
	            $entry->setComponentId($row->component_component_id);
	            $entry->setProduct($row->product_id);
			    $entry->setServer($row->server_id);
			    $entry->setClient($row->client_id);
	            $entry->setName($row->title);
	            $entries[] = $entry;
	        }
	        return $entries;
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }    
    
 
    public function findbyId($id)
    {
    	$component = new Application_Model_Component();
    	$result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $component->setId($row->component_id);
        $component->setComponentId($row->component_component_id);
	    $component->setServer($row->server_id);
	    $component->setClient($row->client_id);
        $component->setProduct($row->product_id);
        $component->setName($row->title);
    	return $component;
    }
        
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de component
     */
    public function fetchAll($data=null)
    {
    	try{   		
			$select = $this->db->select()
								->where("client_id = ?", $this->client->client_id);
	
			if($data['server_id'])
				$select->where("server_id = ?", $data['server_id']);

			if($data['title'])
				$select->where("upper(title) like '%".strtoupper($data['title'])."%'");

			if($data['component_id'] > 0)
				$select->where("component_id = ?", $data['component_id']);
				
			if($data['product_id'] > 0)
				$select->where("product_id = ?", $data['product_id']);

			if($data['component_component_id'] > 0)
				$select->where("component_component_id = ?", $data['component_component_id']);
			
			$select->order(array("server_id", "component_component_id","component_id"));
			$result = $this->db->fetchAll($select);
			if(!$result)
				return false;
	        foreach ($result as $row) {
	            $entry = new Application_Model_Component();
	            $entry->setId($row->component_id);
	            $entry->setComponentId($row->component_component_id);
			    $entry->setServer($row->server_id);
			    $entry->setClient($row->client_id);
	            $entry->setName($row->title);
	            $entry->setProduct($row->product_id);
	            $entries[] = $entry;
	        }
			return $entries;
    	}
    	catch(Exception $e)
    	{
    		echo "Get All Components: ".$e->getMessage();
    		echo "<br /> <br />".$select;
    		exit();
    	}
    } 
    

    /**
     * Método para retornar todos componentes sem dependentes
     * @return array $entry com os objetos de aplicação
     */
    public function getAllRoot($data = null)
    {
    	try {
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false)
			                ->where('client_id = ?', $this->client->client_id);
			$select->joinLeft("Application_Component", "Application_Component.component_id = Component.component_id", array());
			
			if($data['title'])
				$select->where("Component.title like '%{$data['title']}%'");
			
			if($data['component_id'])
				$select->where('Component.component_id = ?', $data['component_id']);
			else
				$select->where('Component.component_component_id = ?', 0);				
			   
			if($data['product_id'])
			   $select->where('product_id = ?', $data['product_id']);
			                			   
			if($data['application_id'])
				$select->where('Application_Component.application_id = ?', $data['application_id']);
			   
			if($data['ambient_id'])
				$select->where('Application_Component.ambient_id = ?', $data['ambient_id']);
				
			$select->group(array("component_id"));
			$result = $this->db->fetchAll($select);
	
	        foreach ($result as $row) 
	        {
	            $entry = new Application_Model_Component();
	            $entry->setId($row->component_id);
	            $entry->setComponentId($row->component_component_id);
			    $entry->setServer($row->server_id);
	            $entry->setProduct($row->product_id);
	            $entry->setName($row->title);
	            $entries[] = $entry;
	        }
	        return $entries;
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }    
    
    /**
     * Método para retornar todos os id de produtos relacionados
     * @param $product_id interger 
     * @return array 
     */
    public function getAll($id)
    {
    	try{
			$select = $this->db->select()
								->where("component_component_id = ?", $id);
			
			$result = $this->db->fetchAll($select);
	        foreach ($result as $row) {
	            $entries[] = $row->component_id;
	        }
	        
	        if(count($entries) > 0)
				return $entries;
			return false;
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    } 
    
    /**
     * Metodo para remover item da tabela
     * @param $id
     */
    public function remove($id)
    {
    	try{
			$where = $this->db->getAdapter()->quoteInto('component_id = ?', $id);
			if($this->db->delete($where))
			{
				$products	= self::getAll($id);
				$subs		= self::removeSubs($products);
				if($subs)
					return $subs;
				return true;
			}
			return false;
        }
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}		
    }    

    /**
	 * Remover subproduto
	 * @param array $products
	 */
	public function removeSubs($itens)
	{
		$rsOut = "";
		if(count($itens) > 0 && is_array($itens))
			foreach($itens as $iten):
				$where		= $this->db->getAdapter()->quoteInto('component_id = ?', $iten);
				$rsOut[]	= $this->db->delete($where);
				self::removeSubs(self::getAll($itens));
			endforeach;	
			
		if(count($rsOut) > 0 && $rsOut)
			return $rsOut;
		return false;
	}    
}
