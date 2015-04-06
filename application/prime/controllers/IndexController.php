<?php


class Prime_IndexController extends Zend_Controller_Action
{
	
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
	}
	
	
    public function indexAction()
    {
    	$user				= Zend_Auth::getInstance()->getIdentity()->getId();
		$profile			= Zend_Auth::getInstance()->getIdentity()->getRoleId();    	
    	$this->view->clients= Zend_Auth::getInstance()->getIdentity()->getClients($profile,$user);
    	    	
    	if($this->_getParam('client_id'))
    	{
    		$id		= $this->_getParam('client_id');
    		$client = $this->_getParam('name');
    		
			$session 				= new Zend_Session_Namespace('client');
			$session->unsetAll('client');
			
			$session->client_name	= $client;
			$session->client_id		= $id;
			$this->_helper->redirector->goToRoute( array('controller' => 'component', 'module' => 'prime'), null, true);
    	}
    }

    
}