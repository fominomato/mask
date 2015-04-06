<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
class Application_Model_ActionLogMapper
{
	//Application_Model_DbTable_ActionLog
    protected $db;
    protected $client;
    protected $user;
    

    function __construct()
    {
    	$this->client	= new Zend_Session_Namespace('client');
    	$this->db		= new Application_Model_DbTable_Actionlog();
    	$this->user		= Zend_Auth::getInstance()->getIdentity();
    }
            
    public function save($data)
    {
    	try{
    		if(!$data['client_id'] || $data['client_id'] < 1)
	    		if($this->client)
	    			$data['client_id'] = $this->client->client_id;
	    	
	    	if(!$data['user_id'])
	    		$data['user_id'] = $this->user->getId();
    			
	        $log = array(
	        	'value'  	=> $data['value'],
	        	'client_id'	=> $data['client_id'],
	        	'object_id'	=> $data['object_id'],
	        	'command_id'=> $data['command_id'],
	        	'user_id'	=> $data['user_id'],
	        	'action_id'	=> $data['action_id']
	        );
	  		
			return $this->db->insert($log);
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }

 
    public function find($id)
    {
     	$result = $this->db->find($id);
        if (0 == count($result)) {
            return false;
        }
        return $result->current();
    }
 
    /**
     * Método para retornar todos itens da Classe
     * @return array $entry com os objetos de logaction
     */
    public function fetchAll($data=null)
    {
    	try
    	{
    		$select = $this->db->select()
	                			->setIntegrityCheck(false)
	                			->from(array("l" => "Action_Log"))
	                			->join(array("u" => 'User'), 'u.user_id = l.user_id', array("user" => "u.name"))
	                			->join(array("a" => 'Action'), 'a.action_id = l.action_id', array("action" => "a.title"))
	                			->join(array("c" => 'Client'), 'c.client_id = l.client_id', array("client" => "c.name"))
	                			->join(array("o" => 'Component'), 'o.component_id = l.object_id', array("component" => "o.title"))
	                			->join(array("s" => 'Server'), 's.server_id = o.server_id', array("server" => "s.hostname"))
	                			->group("l.logaction_id")
	                			->order("l.logaction_id DESC");
	                			
			$select->where("a.action_id = 1");
	        if($data['user_id'])
				$select->where("u.user_id = {$data['user_id']}");
				
			if($data['date_ini'] && $data['date_end'])
				$select->where("l.dtinsert between STR_TO_DATE('{$data['date_ini']}', '%d/%m/%Y') AND STR_TO_DATE('{$data['date_end']}', '%d/%m/%Y')");

			$rows = $this->db->fetchAll($select);
			foreach($rows as $row)
			{
				$rsOut[] = $row;
			}
			return $rsOut;
    	}
    	catch (Exception $e)
    	{
    		echo "Error: get all logs: ".$e->getMessage();
    		exit();
    	}
    }
}
