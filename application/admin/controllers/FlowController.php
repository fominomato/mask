<?php

/**
 * Classe para cadastro de fluxos
 * @author guarient
 *
 */
class Admin_FlowController extends Zend_Controller_Action
{
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
	}
	
    public function indexAction()
    {
    	//$check 				= new App_Plugins_Boxtree_BoxTreeCommandProduct();
    	//$this->view->check 	= $check->renderCheck();
    	$this->view->message= $this->_getParam('message');	
    }
    
    /**
     * Método para gravar uma nova Associação
     */
    public function assocAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar

		$msg = $this->_helper->flow->flowAssoc($this->_getAllParams());
		$this->_forward("index", "flow", "admin", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }

    /**
     * Método para remover um produto
     */
    public function removeassocAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar

    	$msg	= "<div class='error'>Escolha um produto para exclusão.</div>";
    	if($this->_getParam('product_id') && $this->_getParam('command_flow_id'))
       		$msg = $this->_helper->flow->removeAssoc($this->_getAllParams());
       		
    	$this->_forward("index", "flow", "admin", array('message' => $msg));
    }
}