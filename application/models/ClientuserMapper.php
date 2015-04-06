<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_ClientuserMapper
{
    protected $db;
 
	public function __construct()
    {
 	
        $this->db = new Application_Model_DbTable_Clientuser();
    }
 
    public function save($client, $user)
    {
    	try{
	    	$data = array(
				    	"client_id"	=> $client,
				    	"user_id" => $user
	    				);
	    	return $this->db->insert($data);
    	}
    	catch(Exception $e){
    		echo $e->getMessage();
    		exit();
    	}
    }

    /**
     * Metodo para buscar clients e popular objeto para alimentar sessao
     * @param string $profile
     * @param interger $user
     * @return Application_Model_Clientuser
     */
    public function findbyUser($profile=null, $user)
    {
    	try{
			 if($profile == 1)
			 	return self::findAll();
			 
        	$db		= new Application_Model_DbTable_Client();
    		$select = $db->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			                ->setIntegrityCheck(false)
							->join('client_user', 'client_user.client_id = Client.client_id', array());
		 	$select->where("client_user.user_id = ?", $user);
		 	if($profile)
		 	{
		 		$select->join('User', 'User.user_id = client_user.user_id', array());
		 		$select->where("User.profile_id = ?", $profile);
		 	}

	        $resultSet = $db->fetchAll($select);
	        foreach ($resultSet as $row) {
	            $entry		= new Application_Model_Client();
	        	$entry->setId($row->client_id);
	            $entry->setName($row->name);
	            $entries[]	= $entry;
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
     * Método para retornar todos clientes cadastrados
     * @return array Application_Model_Clientuser
     */
    public function findAll()
    {
    	try{
        	$db		= new Application_Model_DbTable_Client();
	        $resultSet = $db->fetchAll();
	        foreach ($resultSet as $row) {
	            $entry		= new Application_Model_Client();
	        	$entry->setId($row->client_id);
	            $entry->setName($row->name);
	            $entries[]	= $entry;
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
     * @param int $user_id
     */
    public function remove($user_id)
    {
    	try{
			$where = $this->db->getAdapter()->quoteInto('user_id = ?', $user_id);
			return $this->db->delete($where);
    	}catch(Exception $e){
    		return $e->getMessage();
    	}
    }
}
