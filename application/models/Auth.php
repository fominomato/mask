<?php


class Application_Model_Auth
{
	public static function login($login, $passwd)
	{
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		//Inicia o adaptador Zend_Auth para banco de dados
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		$authAdapter->setTableName('User')
					->setIdentityColumn('login')
					->setCredentialColumn('passwd')
					->setCredentialTreatment('SHA1(?)');
		//Define os dados para processar o login
		$authAdapter->setIdentity($login)
					->setCredential($passwd);
		//Faz inner join dos dados do perfil no SELECT do Auth_Adapter
		$select = $authAdapter->getDbSelect();
		$select->join( array('p' => 'profile'), 'p.profile_id = User.profile_id', array('title'));
		//Efetua o login
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($authAdapter);
		//Verifica se o login foi efetuado com sucesso
		if ( $result->isValid() ) {
			//Recupera o objeto do usuário, sem a senha
			$info = $authAdapter->getResultRowObject(null, 'passwd');

			$usuario = new Application_Model_User();
			$usuario->setId ($info->user_id);
			$usuario->setName ($info->name);
			$usuario->setLogin ($info->login);
			$usuario->setRoleId ($info->title);
			$usuario->setStatus ($info->status_id);
			
			$storage = $auth->getStorage();
			$storage->write($usuario);

			return true;
		}
		throw new Exception('Nome de usuário ou senha inválida');
	}
}
