<?php

/**
 * Histórico de execuções
 * @author guarient
 *
 */
Class HistoricController extends Zend_Controller_Action
{
	
	public function init()
	{
		if ( !Zend_Auth::getInstance()->hasIdentity() ) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth'), null, true);
		}
		
    	$session = new Zend_Session_Namespace('client');
		$this->client_id 	= $session->client_id;
		$this->client_name 	= $session->client_name;
		if(!$session->client_id){
			return $this->_helper->redirector->goToRoute( array('controller' => 'index'), null, true);
		}
	}

    public function indexAction()
    {
    	$rsPost				= array("client_id" => $this->client_id);
    	$rsPost				= array_push($rsPost, $this->_getAllParams());   	
    	$mapper				= new Application_Model_ActionlogMapper();
    	$this->view->data	= $mapper->fetchAll($rsPost);
    }

    public function searchAction()
    {
		$this->_helper->layout->disableLayout(); 
    	$rsPost				= $this->_getAllParams();
		$rsPost["client_id"]= $this->client_id;    	
    	$mapper				= new Application_Model_ActionlogMapper();
    	$this->view->data	= $mapper->fetchAll($rsPost);
    	$this->render("list");
    }
}