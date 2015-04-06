<?php
/**
 * Arquivo de mapeamento de tabela
 * @author guarient
 *
 */
define(alteraUser, 2);

class Application_Model_UserMapper
{
	
    protected $db;
 
    public function __construct()
    {
        $this->db = new Application_Model_Dbtable_User();
    }

    /**
     * Método para armazenar novo usuario ou atualizar existente
     * @param array $data
     * @return mixed|unknown
     */
    public function save($data)
    {
    	try{
	        $insert = array(
	        	'name'		=> $data['name'],
	        	'login'		=> $data['login'],
	        	'passwd'	=> sha1($data['pass'])
	        );

			$update = array();
			if($data['pass'])
	        	$update["passwd"] = $data['pass'];
	        
	        if($data['profile_id'])
	        	$update["profile_id"] = $data['profile_id'];
	
	        if($data['status_id'])
	        	$update["status_id"] = $data['status_id'];
	        	
	        $id = $data['user_id'];
	        if (null == $id)
	            $user = $this->db->insert($insert);
	        else
	            $id = $this->db->update($update, array('user_id = ?' => $id));
	      
			$clients = $data['client_id'];     
			if(is_array($clients))
			{
				$cMapper =  new Application_Model_ClientuserMapper();
	      
				if($data['user_id'])
				{
					$user['user_id'] = $data['user_id'];
					$cMapper->remove($user['user_id']);	
				}
	      
				foreach($clients as $client)
					$id.= $cMapper->save($client, $user['user_id']);	
			}
			return $id;
    	}catch(Exception $e){
    		echo $e->getMessage();
    		exit();
    	}
    }
    
    public function resetPass($data)
    {
    	$update				= array();
    	$update['passwd']	= sha1($data['pass']);
	    if($this->db->update($update, array('user_id = ?' => $data['user_id'])))
	    	return true;
	    return false;    	
    }
    
    public function getLogin($email)
    {
    	try{
			$select = $this->db->select();
			if($email)
				$select->where("login like '{$email}'");
			$result = $this->db->fetchAll($select);
	        foreach ($result as $row) 
	            if($row->user_id)
	            	return true;
	        return false;
        }catch(Exception $e){
    		echo $e->getMessage();
    		exit();
    	}        
    }
    
    /**
     * Return all registers
     * @param unknown_type $data
     * @return Application_Model_User
     */
    public function fetchAllUsers($data = null)
    {
    	try{
	        $select = $this->db->select();
	       	$select->where("profile_id != 1");
	       	
	        if(strlen($data['login']) > 1)
	       		$select->where("upper(login) like '".strtoupper($data['login'])."'");	       	
	       		
	        if(strlen($data['texto']) > 1)
	       		$select->where("upper(name) like '%".strtoupper($data['texto'])."%'");
	
	        if($data['profile_id'])
	       		$select->where("profile_id = ?", $data['profile_id']);
	
	        if($data['status_id'])
	       		$select->where("status_id = ?", $data['status_id']);
	       		
	       	$select->order("user_id DESC");
	       	$result = $this->db->fetchAll($select);
	        foreach ($result as $row) {
	        	$entry = new Application_Model_User();
	            $entry->setId($row->user_id);
	            $entry->setName($row->name);
	            $entry->setLogin($row->login);
	            $entry->setRoleId($row->profile_id);
	            $entry->setStatus($row->status_id);
	            $entries[] = $entry;
	        }
	        return $entries;
    	}catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();		
    	}
    }
    
    /**
     * Método para gravar o log 
     * @param $data
     * @param $value
     */
    function saveLog($data, $value)
    {
        $logMapper	= new Application_Model_ActionlogMapper();
	        $log = array(
	        	'value'  	=> $value,
	        	'object_id'	=> $data['user_id'],
	        	'user_id'	=> $data['user_id'],
	        	'command_id'=> "",
	        	'action_id'	=> alteraUser
	        );		        	
        
		if(is_array($data['client_id']))
		{
	        foreach($data['client_id'] as $client)
	        {
	        	$log['client_id'] = $client;
	        	$rsOut.= $logMapper->save($log);
    	    }
   		}
    	elseif($data['client_id']){
    		$log['client_id'] = $data['client_id'];
        	$rsOut = $logMapper->save($log);
    	}
        elseif($data['user_id']){
        	$rsOut = $logMapper->save($log);
    	}    		
        return $rsOut;    	
    }
    
    /**
     * Método para serializar o objeto de usua´rio em vetor
     * @param array $data
     * 
     */
    function serialUser ($data)
    {
    	$lsUser = self::fetchAllUsers($data);
    	foreach($lsUser as $user)
    	{
    		$entries[] = $user->getRoleId();
    		$entries[] = $user->getStatus();
    	}
    	return serialize($entries);
    }
}
