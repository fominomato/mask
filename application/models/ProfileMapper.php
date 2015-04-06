<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_ProfileMapper
{
	//Application_Model_DbTable_Profile
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_Dbtable_Profile();
    }

     
    /**
     * Metodo para buscar e retorno em formato array para gerar command
     * @param unknown_type $data
     */
    public function fetchAll($data =  null)
    {
    	try{
	        $select = $this->db->select();
	        if($data['title'])
	       		$select->where("title like '{$data['title']}'");    		
	        
	       	if($data['profile_id'])
	       		$select->where("profile_id = ? ", $data['profile_id']);    		
	       	return $this->db->fetchAll($select);
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }
}
