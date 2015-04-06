<?php

/**
 * Classe inicial para o módulo de monitoração
 * @author guarient
 *
 */
class Monitor_ExecuteController extends Zend_Controller_Action
{
  
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
    		return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
	}
	
    public function indexAction()
    {
    	$this->_helper->layout->disableLayout();
    	$this->view->server_id = "14.196.6.47";

    }
    
	
    public function reload()
    {
    	$this->_helper->layout->disableLayout();
    	$this->view->server_id = "14.196.6.47";

    }    
    
}
