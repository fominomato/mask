<?php

//application/Bootstrap.php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap 
{
    protected $_config;
	protected $_frontController;
	
 
    protected function _initConfig()
    {	        	           
    	// Carrega meu arquivo de configuração application.ini com alguns parâmetros.    	
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/default/configs/application.ini');
        // Registra essa configuração como global. Para recuperar utilize  Zend_Registry::get('config');
        Zend_Registry::set('config', $this->_config);      
    }
      
    protected function _initFrontController()
    {
    	// Recebo uma instância do Zend_Controller_Front::getInstance();
        $this->_frontController = Zend_Controller_Front::getInstance();                
        
        /*
         Você deve utilizar o setControllerDirectory, serve para dizer aonde estão 
         os seus controladores, com essa configuração
         podemos renderizar módulos diferentes, basta dizer o path.                          
        */
		$this->_frontController->setControllerDirectory(array(
		    'default' => APPLICATION_PATH . '/default/controllers',
		    'prime'   => APPLICATION_PATH . '/prime/controllers',		    
		    'monitor' => APPLICATION_PATH . '/monitor/controllers',		    
			'admin'   => APPLICATION_PATH . '/admin/controllers'		    
		    ));		
		
		/*
		 Somente no controlador default, não é preciso digitar o name space.
		 No caso do admin, que precisamos digitar, você deve escrever suas classes desta forma:
		  
		 class Admin_IndexController extends Zend_Controller_Action		  		  
		*/			
    }
    
	/**
     * Metodo de Autoload
     */
    protected function _initAutoload()
    {
		$autoLoader = Zend_Loader_Autoloader::getInstance();
		$autoLoader->setFallbackAutoloader(true);
    	
        $autoloader = new Zend_Application_Module_Autoloader(
		        array(
		            'basePath'		=> APPLICATION_PATH,
		        	'namespace' 	=> 'Application',
		            'resourceTypes' => array(
		        							'App'=>array('path'=>'/library',
														 'namespace'=>'App'
		        										)	        										
		        							)
					)
		        );
    }
    

    /**
     * Inicializar a autenticação e permissionamento
     */
	protected function _initAcl()
	{
		$aclSetup = new App_Plugins_Acl_Setup();
	}
   
    
    /**
     * Metodos para renderizar layouts atraves de um modulo
     */
	protected function _initView()
	{
		$view = new Zend_View;
		$view->setEncoding('UTF-8');
		
		Zend_Layout::startMvc(
			array(
				'layoutPath' => APPLICATION_PATH . '/default/views/layouts/scripts',
				'layout' => 'default', // default deve ser o nome do arquivo. Ex: default.phtml
				'pluginClass' => 'App_Plugins_SetLayout' // é aqui onde acontece a mágica
			)
		);
	}    

 
   
    public function run()
    {         
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/../library/Helpers/Action', 'Zend_Controller_Action_Helper');
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/default/forms', 'Zend_Form');
		
    	/* 
    	 Dispatch faz um processo que pega o objeto de requisição, 
    	 Zend_Controller_Request_Abstract Exrai o nome do modulo, controller, 
    	 action e parâmetros opcionais.    	
    	*/
    	
		$this->_frontController->dispatch();
    }
}
