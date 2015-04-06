<?php

/** Constantes para mensagens da aplicação após uma ação*/
define(update,"Registro atualizado.");
define(insert,"Novo registro adicionado.");
define(remove,"Registro removido.");

class Prime_ServerController extends Zend_Controller_Action
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
    	
		$this->view->data 	= $this->_helper->server->get($this->_getParam('server_id'));
		$this->view->server	= $this->_helper->server->getAll();
		$this->view->msg	= $this->_getParam('message');
    }
    
    /**
     * Método para gravar um component
     */
    public function saveAction()
    {
		$this->_helper->layout->disableLayout(); 
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
    	$rsOut = $this->_helper->server->save($this->_getAllParams());
	    	
	    if(is_numeric($rsOut))//se retorno numero então sucesso e retornar id
	    	$msg = insert;
	    elseif(strlen($rsOut) > 4)//se erro, então mensagem de erro
	    	$msg = $rsOut;
	    else
	    	$msg = update;
		$this->_forward("index", "server", "prime", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }

    /**
     * Método para remover um component
     */
    public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
   		$rsOut = $this->_helper->server->remove($this->_getParam('server_id'));
   		
   		if($rsOut)
   			$msg = $rsOut;
    	else
    		$msg = remove;
    	
    	$this->_forward("index", "server", "prime", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }

    /**
     * Metodo para listagem de componentes
     */
    public function listAction()
    {
		$this->_helper->layout->disableLayout();

		if($this->_getParam("product_id"))
			$this->view->components	= $this->_helper->component->getAll($this->_getAllParams());
		$this->view->component = $this->_getParam('component');
    }

    /**
     * Metodo para criar uma box de servidores
     */
    public function boxAction()
    {
		$this->_helper->layout->disableLayout();
    }    
}