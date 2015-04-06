<?php

/**
 * Classe para administração de usuários
 * @author guarient
 *
 */
class Admin_UserController extends Zend_Controller_Action
{
	public function _init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
			return $this->_helper->redirector->goToRoute( array('module' => 'default', 'controller' => 'auth', 'action'=> 'logout'), null, true);
		}
	}
	
    public function indexAction()
    {
    	$userId = "";
		$this->view->select = "";
		$this->view->list   = $this->_helper->user->getUser();
		$this->view->msg	= $this->_getParam('message');	
    }
    
    /**
     * Método para gravar um cliente
     */
    public function saveAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
    	$rsOut = $this->_helper->user->update($this->_getAllParams());
		$this->_forward("index", "user", "admin", array('message' => $rsOut, 'data'=> $this->_getAllParams()) );
    }

    
}