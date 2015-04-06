<?php


class IndexController extends Zend_Controller_Action
{
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth'), null, true);
		}
	}
	
    public function indexAction()
    {
		$session 				= new Zend_Session_Namespace('client');
    	$user				= Zend_Auth::getInstance()->getIdentity()->getId();
		$profile			= Zend_Auth::getInstance()->getIdentity()->getRoleId();
		$this->view->clients= Zend_Auth::getInstance()->getIdentity()->getClients($profile, $user);
    	
    	if($this->_getParam('client_id'))
    	{
    		list($id, $client) 		= explode(":", $this->_getParam('client_id'));
    		
			$session 				= new Zend_Session_Namespace('client');
			$session->unsetAll('client');
			
			$session->client_name	= $client;
			$session->client_id		= $id;
			$this->_helper->redirector->goToRoute( array('controller' => 'find'), null, true);
    	}
    	
    }
    
}