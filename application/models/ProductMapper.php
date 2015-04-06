<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_ProductMapper
{
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_DbTable_Product();
    }
    
 
    public function save($data)
    {
        $product["title"] = ucfirst($data['title']);
        
        if($data['product_id'] > 0)
        	$product['product_product_id'] = $data['product_id'];
  		
        $id = $data['id'];
        if (null == $id)
            return $this->db->insert($product);
		return $this->db->update($product, array('product_id = ?' => $id));
    }
     
 
    public function find($id, Application_Model_Product $product)
    {
        $result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        
        $product->setId($row->product_id);
        $product->setName($row->title);
    }
    
    
    public function findbyId($id, $component_id=null)
    {
    	$product	= new Application_Model_Product();
        $result		= $this->db->find($id);
        $row		= $result->current();
        
        $product->setId($row->product_id);
        $product->setName($row->title);
        
        return $product;
    } 
    
    
    /**
     * Método para retornar todos itens da Classe
     * @param array $data
     * @return array $entry com os objetos de produto
     */
    public function fetchAll($data = null)
    {
        $select = $this->db->select();
        
        if($data['title'])
       		$select->where("title like '{$data['title']}'");

        if($data['product_product_id'] > 0)
       		$select->where("product_product_id = ?", $data['product_product_id']);
       		
       	$result = $this->db->fetchAll($select);
        foreach ($result as $row) {
            $entry = new Application_Model_Product();
            $entry->setId($row->product_id);
            $entry->setName($row->title);
            $entry->setProductId($row->product_product_id);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    /**
     * Método para retornar todos os id de produtos relacionados
     * @param $product_id interger 
     * @return array 
     */
    public function getAll($product_id)
    {
    	try{
			if($product_id == 0)
    			return false;
    			    		
			$select = $this->db->select()
								->where("product_product_id = ?", $product_id);
			$result = $this->db->fetchAll($select);
	        foreach ($result as $row) {
	            $entries[] = $row->product_id;
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
     * Método para retornar todos componentes sem dependentes
     * @return array $entry com os objetos de aplicação
     */
    public function getAllRoot($data = null)
    {
    	try {
    			
			$select = $this->db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false);
			   
			if($data['product_id'])
				$select->where('product_id = ?', $data['product_id']);
			else
				$select->where('product_product_id = ?', 0);
			  
			$result = $this->db->fetchAll($select);
	        foreach ($result as $row) 
	        {
	            $entry = new Application_Model_Product();
	            $entry->setId($row->product_id);
	            $entry->setProductId($row->product_product_id);
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
     * Metodo para remover item da tabela
     * @param $id
     */
    public function remove($id)
    {
		$where = $this->db->getAdapter()->quoteInto('product_id = ?', $id);
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

    /**
	 * Remover subproduto
	 * @param array $products
	 */
	public function removeSubs($products)
	{
		$rsOut = "";
		if(count($products) > 0 && is_array($products))
			foreach($products as $product):
				$where		= $this->db->getAdapter()->quoteInto('product_id = ?', $product);
				$rsOut[]	= $this->db->delete($where);
				self::removeSubs(self::getAll($product));
			endforeach;	
			
		if(count($rsOut) > 0 && $rsOut)
			return $rsOut;
		return false;
	}

}
