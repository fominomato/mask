<?php

/** Constantes para mensagens da aplicação após uma ação*/
define(update,"Registro atualizado.");
define(insert,"Novo registro adicionado.");
define(remove,"Registro removido.");

class Prime_ClientController extends Zend_Controller_Action
{
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
	}
	
    public function indexAction()
    {
    	$userId = "";
		$this->view->select = "";
		$this->view->select = $this->_helper->client->get($this->_getParam('client_id'));
		$this->view->client = $this->_helper->client->getAll($this->_getParam('data'));
		$this->view->msg	= $this->_getParam('message');	
    }
    
    /**
     * Método para gravar um cliente
     */
    public function saveAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
    	$rsOut = $this->_helper->client->save($this->_getAllParams());
	    	
	    if($rsOut > 0 && !$this->_getParam('client_id'))//se retorno numero então sucesso e retornar id
	    	$msg = insert;
	    elseif(is_string($rsOut))//se erro, então mensagem de erro
	    	$msg = $rsOut;
	    else
	    	$msg = update;
	    	
		$this->_forward("index", "client", "prime", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }

    /**
     * Método para remover um cliente
     */
    public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
   		$rsOut = $this->_helper->client->remove($this->_getParam('client_id'));
   		
   		if($rsOut)
    		$msg = remove;
    	else
    		$msg = $rsOut;
    	
    	$this->_forward("index", "client", "prime", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }    
}