<?php


Class FindController extends Zend_Controller_Action
{
	
	public function init()
	{
		if ( !Zend_Auth::getInstance()->hasIdentity() ) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth'), null, true);
		}
		
    	$session = new Zend_Session_Namespace('client');
		$this->client_id 	= $session->client_id;
		$this->client_name 	= $session->client_name;
		if(!$session->client_id)
			return $this->_helper->redirector->goToRoute( array('controller' => 'index'), null, true);
		}
	
    public function indexAction()
    {
    	$this->view->client_id	= $this->client_id;
    	$this->view->client_name= $this->client_name;
    	
		$check				= new App_Plugins_Boxtree_BoxTreeComponent();		
    	$this->view->check	=  $check->renderCheck($this->_getAllParams());
    	$this->view->userId = $this->_getParam('userid');
    }

    /**
     * Método para gerar box de ambientes
     */
    public function boxambientAction()
    {	
		$this->_helper->layout->disableLayout(); 
    	$this->view->application_id = $this->_getParam('application_id');
    }
    
    /**
     * Método para gerar box de aplicações
     */
    public function applicationAction()
    {	
		$this->_helper->layout->disableLayout(); 
    	$this->view->client_id = $this->_getParam('client_id');
    }    
     
    /**
     * Método para gerar box de componentes
     */
    public function componentAction()
    {
		$this->_helper->layout->disableLayout(); 
    	$this->view->application_id = $this->_getParam('application_id');
		if($this->_getParam('application_id') == 0)
			$this->view->application_id = null;
    	$this->view->ambient_id		= $this->_getParam('ambient_id');
    }    
    
    /**
     * Metodo para retorno da pesquisa
     */
    public function responseAction()
    {
		$this->_helper->layout->disableLayout(); 
		if($this->_getParam("client_id") && $this->_getParam("client_id") != "")
    		$this->view->data = $this->_helper->search->getOperations($this->_getAllParams());
		else
    		$this->view->error = "Campo cliente não pode ser nulo!";
    }
    
	public static function arrayToParam ($char,$array)
	{
		$a = 0;
		$tmprmv = array("module", "action", "controller");
	    $char 	= htmlentities($char);
	    foreach($array as $key=>$value) {
	    	if(str_replace($tmprmv, "" , $key))
	    	{
		    	if($a > 0)
		        	$str.= $char;
	        	$str .= "{$key}={$value}";
	        	$a++;
	    	}
	    }
	    return $str;
	}    
}