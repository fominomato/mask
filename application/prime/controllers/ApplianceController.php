<?php

/** Constantes para mensagens da aplicação após uma ação*/

define(remove,"Registro removido.");

class Prime_ApplianceController extends Zend_Controller_Action
{
	
	public function init()
	{
		
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
		
    	$session = new Zend_Session_Namespace('client');
		$this->client_id 	= $session->client_id;
		$this->client_name 	= $session->client_name;
		if(!$session->client_id)
			return $this->_helper->redirector->goToRoute( array('controller' => 'index', 'module'=> 'prime', 'action'=>'index'), null, true);
		}
	
    public function indexAction()
    {
    	$this->view->client_id	= $this->client_id;
    	$this->view->client_name= $this->client_name;
    	$this->view->msg		= $this->_getParam('message');
    	$mapper					= new Application_Model_ApplicationComponentMapper();
    	$this->view->data		= $mapper->getAppComp($this->_getAllParams());
    	
    	$data 					= $this->_getAllParams();
    	if(empty($data['title']) || empty($data['component']))
    		$data['component_component_id'] = "0";
    	$this->view->application= $mapper->fetchAll($data);

    	$check					= new App_Plugins_Boxtree_BoxTreeComponent();
    	$this->view->check 		= $check->renderCheck();
    }
    

    /**
     * Método para gravar uma application
     */
    public function saveAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
    	$msg = $this->_helper->application->save($this->_getAllParams());
		$this->_forward("index", "appliance", "prime", array('message' => $msg));
    }

    /**
     * Método para remover uma application
     */
    public function removeAction()
    {
		$this->_helper->layout->disableLayout(); 
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
   		$msg = $this->_helper->application->remove($this->_getAllParams());
		$this->_forward("index", "appliance", "prime", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }


    public function listappAction()
    {
		$this->_helper->layout->disableLayout(); 
   		$this->view->application= $this->_helper->application->getAll($this->_getAllParams());
   		if($this->_getParam('message'))
   			$this->view->message = $this->_getParam('message');
    }

    public function editAction()
    {
		$this->_helper->layout->disableLayout(); 
    	$this->view->data		= $this->_helper->application->get("", $this->_getParam('application_component_id'));
    	$this->view->msg		= $this->_getParam('message');
    	$this->view->client_id	= $this->client_id;
    }    
}