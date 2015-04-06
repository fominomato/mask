<?php
/**
 * Arquivo para carregar Layout de acordo com o módulo acionado
 * @author guarient
 *
 */
class App_Plugins_SetLayout extends Zend_Layout_Controller_Plugin_Layout
{
	
	// o preDispatch é chamado antes de uma ação ser despachada pelo dispatcher
	// com isso, usamos o nosso objeto request e extraimos o nome do módulo
	public function preDispatch (Zend_Controller_Request_Abstract $request)
	{
		switch ($request->getModuleName()) {
			case 'admin':
				$this->_setupLayout('admin');
			break;
				
			case 'monitor':
				$this->_setupLayout('monitor');
			break;
				
			case 'prime':
				$this->_setupLayout('prime');
			break;
		}
	}
	
	/**
	 * Método para setar layout 
	 * @param $moduleName
	 */
	protected function _setupLayout ($moduleName)
	{
		$this->getLayout()->setLayoutPath(APPLICATION_PATH . '/' . $moduleName . '/views/layouts/scripts');
		$this->getLayout()->setLayout($moduleName);
	}

}
