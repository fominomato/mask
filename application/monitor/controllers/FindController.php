<?php

/**
 * Classe de pesquisa para o módulo de monitoração
 * @author guarient
 *
 */
class Monitor_FindController extends Zend_Controller_Action
{
  
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity() || Zend_Auth::getInstance()->getIdentity()->getRoleId() != 1) {
    		return $this->_helper->redirector->goToRoute( array('controller' => 'auth', 'action'=> 'logout'), null, true);
		}
	}
	
    public function indexAction()
    {
    	$mem = new Memcache;
    	$mem->connect('148.91.91.204', '33001') or die("Erro: não foi possível conectar.");
    	var_dump($mem->get("HBT"));
    	exit();
    }
   
}
