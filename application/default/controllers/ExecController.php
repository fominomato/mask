<?php

define(rootPath, $_SERVER['DOCUMENT_ROOT'].'/tmp/');
define(errorMail, "Ops: este email não pode ser entregue devido há problemas que estão fora de nosso alcance.");
define(subjectEmail, "'[HBGT] Cobradaaaaaaaaa!'");
define(smtpServer, "plmlir1.mail.eds.com");

Class ExecController extends Zend_Controller_Action
{
	
	public function init()
	{
		if ( !Zend_Auth::getInstance()->hasIdentity() ) {
			return $this->_helper->redirector->goToRoute( array('controller' => 'auth'), null, true);
		}
    	$session = new Zend_Session_Namespace('client');
		$this->client_id 	= $session->client_id;
		$this->client_name 	= $session->client_name;		
	}
		
    public function indexAction()
    {
    	$this->_helper->layout->disableLayout();
		$mapper 			= new Application_Model_ApplicationComponentMapper();
		$this->view->appCom = $mapper->fetchOne($this->_getAllParams());
    }

    public function subcompAction(){}
    
    public function commandAction()
    {
    	try{
			$this->_helper->layout->disableLayout();
			$mapper 			= new Application_Model_ComponentMapper();
			$this->view->comp	= $mapper->findbyId($this->_getParam("component_id"));
			
			$fmapper			= new Application_Model_CommandFlowMapper();
			$this->view->command= new Application_Model_CommandFlow();
			$fmapper->find(array("command_flow_id"=>$this->_getParam("flow_id")), $this->view->command);
			$this->view->client_name	= $this->client_name;
    	}
    	catch(Exception $e)
    	{
    		echo $e->getMessage();
    		exit();
    	}
    }
    
    /**
     * Metodo de ação para a função de retornar arquivo de log para visualização
     */
    public function downloadAction()
    {
		$this->_helper->layout->disableLayout();
    	$this->view->file = $this->_getParam("url");
    }
    
    
    /**
     * Metodo de ação para envio de email
     */
    public function sendemailAction()
    {
    	try{
	    	//meu ip 148.91.214.184
			$this->_helper->layout->disableLayout();
			$this->_helper->viewRenderer->setNoRender();//sem renderizar
			
	    	$file 	= file_get_contents($this->_getParam("url"));
	    	$client = $this->_helper->client->get($this->_getParam("client"));
	    	
			$config = array('port' => '25');    
			
			$tr = new Zend_Mail_Transport_Smtp(smtpServer, $config);
		
			$mail = new Zend_Mail();
			
				$at = new Zend_Mime_Part($file);
				$at->type        = 'text/plain';
				$at->disposition = Zend_Mime::DISPOSITION_INLINE;
				$at->encoding    = Zend_Mime::ENCODING_BASE64;
				$at->filename    = basename($this->_getParam("url"));
	
			$mail->addAttachment($at);
			$mail->setFrom($client->getEmail(), $client->getName());
			$mail->addTo($client->getEmail(), $client->getName());
			$mail->setSubject(subjectEmail);
			$mail->setBodyText('Log em anexo');
			$rsOut = $mail->send($tr);
			if($rsOut)
				$response =	$rsOut;
			else
				$response =	errorMail;
				
			echo $response;    		
    	}catch(Exception $e)
    	{
    		echo "<div style='color:#FFFFFF'>{$e->getMessage()}</div>";	
    	}
    }
}   
