<?php

/**
 * Classe para cadastro de produtos
 * @author guarient
 *
 */
class Admin_ProductController extends Zend_Controller_Action
{
	public function _init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
	}
	
    public function indexAction()
    {
    	$check 				= new App_Plugins_Boxtree_BoxTreeProduct();
    	$this->view->check 	= $check->renderCheck();
    	$this->view->message= $this->_getParam('message');	
    }
    
    /**
     * Método para gravar um produto
     */
    public function saveAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
       	$msg = $this->_helper->product->save($this->_getAllParams());
       	
		$this->_forward("index", "product", "admin", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }

    /**
     * Método para remover um produto
     */
    public function removeAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
    	
    	$msg	= "<div class='error'>Escolha um produto para exclusão.</div>";
    	if($this->_getParam('product_id'))
       		$msg = $this->_helper->product->remove($this->_getParam('product_id'));
    	    	
    	$this->_forward("index", "product", "admin", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }    
}