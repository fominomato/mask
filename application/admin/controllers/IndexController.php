<?php

//application/admin/controllers/IndexController.php

class Admin_IndexController extends Zend_Controller_Action
{
  
    public function indexAction()
    {
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
    		return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
		$this->view->admin = 'Módulo Admin !';
    }
    
}
