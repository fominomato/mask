<?php

/**
 * Classe para o módulo de health Check
 * @author guarient
 *
 */
class Monitor_HealthController extends Zend_Controller_Action
{
  
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
    		return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
		
		$session				= new Zend_Session_Namespace('client');
		if(!$session || !$session->client_id)
			return $this->_helper->redirector->goToRoute( array('module'=>'monitor', 'controller' => 'index', 'action'=> 'index'), null, true);
			
		$this->client_id 		= $session->client_id;
		$this->client_name 		= $session->client_name;
	}
	
    public function indexAction()
    {
    	try{
	 		$mapper					= new Application_Model_ServerMapper();
	 		$this->view->servers	= $mapper->fetchAll();
	    	$this->view->client_id  = $this->client_id;
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    	
    }
    
    public function listAction()
    {
    	$this->_helper->layout->disableLayout();
	 	$this->view->server_id	= $this->_getParam('server_id');
    }
}