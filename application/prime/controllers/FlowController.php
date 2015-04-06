<?php

/** Constantes para mensagens da aplicação após uma ação*/
define(update,"Registro atualizado.");
define(insert,"Novo registro adicionado.");
define(remove,"Registro removido.");

class Prime_FlowController extends Zend_Controller_Action
{

	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
	}
	
    public function indexAction()
    {
    	$this->view->process_id = $this->_getParam('flow_component_id');
    	$this->view->select 	= $this->_helper->flow->get($this->_getParam('command_flow_id'));
		$flowMapper				= new Application_Model_FlowMapper();
		$this->view->flow		= $flowMapper->getFlowbyProcess($this->_getAllParams());    	
		$this->view->msg		= $this->_getParam('message');
    }
    
    /**
     * Método para gravar um fluxo
     */
    public function saveAction()
    {
		$this->_helper->layout->disableLayout(); 
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar

    	//senao vier o command
    	if($this->_getParam("command_id")){
    		$rsOut = $this->_helper->flow->save($this->_getAllParams());
    	}
    	
	    if(is_numeric($rsOut))//se retorno numero então sucesso e retornar id
	    	$msg = insert;
	    elseif(strlen($rsOut) > 5)//se erro, então mensagem de erro
	    	$msg = $rsOut;
	    elseif($rsOut)
	    	$msg = update;
	    else 
	    	$msg = "Erro: verifique se existe um comando cadastrado.";
	    	
		$this->_forward("index", "flow", "prime", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }

    /**
     * Método para remover uma flow
     */
    public function deleteAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
   		$rsOut = $this->_helper->flow->remove($this->_getParam('comand_flow_id'));
   		
   		if(is_numeric($rsOut))
    		$msg = remove;
    	else
    		$msg = $rsOut;
    	
    	$this->_forward("index", "flow", "prime", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }


    /**
     * Método para retorna comandos
     */
    public function getcommandAction()
    {
		$this->_helper->layout->disableLayout(); 
    	
    	try{
			$commandMapper = new Application_Model_CommandMapper();
			$this->view->command = $commandMapper->fetchAll($this->_getAllParams());
    	}catch(Exception $e){
    		echo $e->getMessage();
    		exit();
    	}
    }        
}