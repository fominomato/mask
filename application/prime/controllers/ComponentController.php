<?php

/** 
 * Classe para manutenção de componentes
 * 
 */

class Prime_ComponentController extends Zend_Controller_Action
{

	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
		$session				= new Zend_Session_Namespace('client');
		if(!$session || !$session->client_id)
			return $this->_helper->redirector->goToRoute( array('module'=>'prime', 'controller' => 'index', 'action'=> 'index'), null, true);
			
		$this->client_id 		= $session->client_id;
		$this->client_name 		= $session->client_name;
	}
	
    public function indexAction()
    {
    	$check					= new App_Plugins_Boxtree_BoxTreeComponent();
    	$this->view->comp 		= $check->renderCheck();
    	$this->view->message	= $this->_getParam('message');	
    	$this->view->client_name= $this->client_name;
  	
    }
        
    /**
     * Método para gravar um component
     */
    public function saveAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
    	$rsOut = $this->_helper->component->save($this->_getAllParams());

    	if($rsOut['return'] == 1)
			return $this->_forward("assoc", "component", "prime", array('message' => $rsOut['message'], 'id'=> $rsOut['id'], 'product_id'=> $rsOut['product_id']) );
		return $this->_forward("index", "component", "prime", array('message' => $rsOut['message'], 'id'=> $rsOut['id'], 'product_id'=> $rsOut['product_id']) );
    }
        
    /**
     * Método para atualizar um component
     */
    public function updateAction()
    {
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
    	$msg = $this->_helper->component->update($this->_getAllParams());
		$this->_forward("args", "component", "prime", array('message' => $msg, 'data'=> $this->_getAllParams()) );
    }    
    
    /**
     * Método para remover um component
     */
    public function removeAction()
    {
    	$check					= new App_Plugins_Boxtree_BoxTreeComponent();
		$this->_helper->layout->disableLayout(); 
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar
   		$msg = $this->_helper->component->remove($this->_getParam('component_id'));
   		if($msg)
   			echo $check->renderCheck();
   		echo false;

 	}

    /**
     * Metodo para listagem de componentes
     */
    public function searchAction()
    {
    	$mapper					=  new Application_Model_ComponentMapper();
    	if($this->_getParam('title'))
    		$this->view->list		= $mapper->getAllRoot($this->_getAllParams());
    	else 	
    		$this->view->list		= $mapper->getAllRoot();
    	$this->view->message	= $this->_getParam('message');
    	$this->view->title		= $this->_getParam('title');
    }
    
    /**
     * Metodo para apressentaRr o formulario de associação
     */
    public function assocAction()
    {
    	if($this->_getParam('id'))
    	{
    		$mapper					=  new Application_Model_ComponentMapper();
    		$this->view->component	= $mapper->findbyId($this->_getParam('id'));
    	}
    	$checkProd				= new App_Plugins_Boxtree_BoxTreeProduct();
    	$this->view->prod		= $checkProd->renderCheck($this->_getAllParams());
    	$this->view->message	= $this->_getParam('message');	
    }
    

    /**
     * Metodo para listagem de argumentos
     */
    public function argsAction()
    {
    	$this->view->render = $this->_getParam('render');
    	if($this->_getParam('render') == 2)
    		$this->_helper->layout->disableLayout();//não renderizar o layout
    	
    	if(!$this->_getParam('component_id'))
			return $this->_forward("search", "component", "prime" );
    	
    	$data	= $this->_getParam('data');
		if($this->_getParam('product_id') > 0)
			$data	= $this->_getAllParams();
    		
    	$this->view->message	= $this->_getParam('message');
    	$mapper					= new Application_Model_CommandMapper();
    	$this->view->command	= $mapper->fetchflow($data);
    	$this->view->comp		= $this->_getParam('component_id');
    }
        
    /**
     * Método para gravar um argumento
     */
    public function saveargsAction()
    {
    	$this->_helper->layout->disableLayout();//não renderizar o layout
    	$this->_helper->viewRenderer->setNoRender();//sem renderizar o conteudo
    	$rsOut = $this->_helper->args->save($this->_getAllParams());
		echo $rsOut['message'];
    }    
    
    /**
     * Metodo para criação de box
     */
    public function boxAction()
    {  	
    	$this->_helper->layout->disableLayout();
		$this->view->data = array("product_id"=>$this->_getParam("product_id"));
    }
    
    public function treeAction ()
    {
    	$this->_helper->layout->disableLayout();
//		$this->view->component = $this->_getParam("component_id"); 
     	$check					= new App_Plugins_Boxtree_BoxTreeComponent();
    	$this->view->comp 		= $check->renderCheck($this->_getAllParams());
    }
}