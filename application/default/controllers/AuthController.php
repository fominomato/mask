<?php 


/**
 * Classe de controle para login
 * @author guarient
 *
 */

define(userInsert, "Novo usuário cadastrado!");

class AuthController extends Zend_Controller_Action
{

	public function init()
	{
	}

	public function indexAction()
	{
		return $this->_helper->redirector('login');
	}

	public function loginAction()
	{
    	require_once($_SERVER['DOCUMENT_ROOT'].'/../application/forms/login.php');
		
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->view->messages = $this->_flashMessenger->getMessages();
		$form = new Login();
		$this->view->form = $form;
		//Verifica se existem dados de POST
		if ( $this->getRequest()->isPost() ) {
			$data = $this->getRequest()->getPost();
			//Formulário corretamente preenchido?
			if ( $form->isValid($data) ) {
				$login = $form->getValue('login');
				$passwd = $form->getValue('passwd');

				try {
					Application_Model_Auth::login($login, $passwd);
    				$status = Zend_Auth::getInstance()->getIdentity()->getStatus();
					if ($status != 1) {
						$login = Zend_Auth::getInstance()->getIdentity()->getLogin();
						$auth  = Zend_Auth::getInstance();
						$auth->clearIdentity();
						return $this->_redirect('/Auth/permission', array("login"=>$login));
					}
					
				//Redireciona para o Controller protegido
					$pMapper = new Application_Model_ProfileMapper();
					$profile = $pMapper->fetchAll(array("profile_id" => Zend_Auth::getInstance()->getIdentity()->getRoleId()));

					return $this->_helper->redirector->goToRoute(
									array(
											'action' => 'index',
											'controller' => 'index',
											'module' => $profile[0]->title
										), null, true);
				} catch (Exception $e) {
					//Dados inválidos
					$this->_helper->FlashMessenger($e->getMessage());
					$this->_redirect('/auth/login');
				}
			} else {
				$form->populate($data);//Formulário preenchido de forma incorreta
			}
		}
	}

	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		$this->_helper->redirector('index');
	}
	

	/**
	 * Método para registro de novos usuários (off Line)
	 */
	public function registerAction()
	{
		$this->view->user = $this->_helper->user->setUser($this->_getAllParams());
		if($this->_getParam('login'))
		{
			$msg = $this->_helper->user->save($this->_getAllParams());
			if($msg > 0)
				$msg = userInsert;
		} 
		$this->view->msg = $msg;
	}
	
	public function permissionAction()
	{
		if($this->_getParam('login'))
			echo "teste";
	}

	/**
	 * Método de recuperacao de senha
	 */
	public function rememberAction()
	{
		$mapper = new Application_Model_UserMapper();
		if($this->_getParam("login"))
		{
			$data   = $mapper->fetchAllUsers($this->_getAllParams());
			if(is_array($data) && is_object($data[0]))
				$this->view->msg = $this->_helper->user->updt_pass(array("user_id"=>$data[0]->getId()));
			else
				$this->view->msg = "<div class='error'>Erro: login inválido.</div>";
		}	 
	}	
	
}
