<?php
/**
 * Classe para validação de formulario de aplicação
 * @author guarient
 *
 */

class App_Plugins_Valid_User extends Zend_Validate_Abstract
{

	const LENGTH = 'length';
    const DIGIT  = 'digit';
    const NULL   = 'null';
    const EMAIL  = 'email';
    const PASSW  = 'passw';
    const DPLEM  = 'dplem';
    const PASSL  = 'passl';
    
	protected $_messageTemplates = array(
		self::LENGTH 	=> "<div class='error'>'%value%' quantidade de caracteres insuficiente.</div>",
		self::NULL		=> "<div class='error'>O campo '%value%' não foi encontrado.</div>",
		self::EMAIL		=> "<div class='error'>O campo '%value%' esta inválido.</div>",
		self::PASSW		=> "<div class='error'>As senhas não conferem.</div>",
		self::PASSL		=> "<div class='error'>A senha deve ter entre 6 e 8 caracteres.</div>",
		self::DPLEM		=> "<div class='error'>Este login já esta em uso.</div>",
		self::DIGIT  	=> "<div class='error'>O campo '%value%' campo não pode ser nulo.</div>"
	);
	
	public function isValid($valor)
	{
		if(trim($valor['name']) == "" || empty($valor['name'])){
			$this->_setValue('nome');
			$this->_error(self::NULL);
			return false;
		}

		if((trim($valor['login']) == "") || (empty($valor['login']))){
			$this->_setValue('Email');
			$this->_error(self::EMAIL);
			return false;
		}		
		
		if($valor['login'] && (self::validaEmail($valor['login']) == false))
		{
			$this->_setValue('Email');
			$this->_error(self::EMAIL);
			return false;
		}
		
		if(self::validaLogin($valor['login'], "Login") == false){
			$this->_setValue('Email');
			$this->_error(self::EMAIL);
			return false;
		}

		if(!is_array($valor['client_id'])){
			if(self::validaCliente($valor['client_id'], 'Cliente') == false)
				return false;
		}else{
			if(count($valor['client_id']) == 1)
				if(($valor['client_id'][0]== "") || !$valor['client_id']){
					$this->_setValue("cliente");
					$this->_error(self::NULL);
					return false;
				}
		}
		
		if(self::vazioSenha($valor['pass'], 'Senha') == false)
			return false;
				
		if(strcmp($valor['pass'], $valor['confirmpass']) != 0){
			$this->_error(self::PASSW);
			return false;
		}		
		
		if($valor['name'])
			if(self::vazioString($valor['name'], 'Nome') == false)
				return false;

		if($valor['login'])
			if(self::vazioString($valor['login'], 'Email') == false)
				return false;
				
		return true;
	}

	
	/**
	 * Validação de login
	 * @param string $valor
	 * @return boolean|string
	 */
	function validaLogin ($valor, $campo)
	{
		$mapper = new Application_Model_UserMapper();
		$this->_setValue($campo);
		if($valor)
			if($mapper->getLogin($valor) == false)	
				return true;
		$this->_error(self::DPLEM);
		return false;
	}	
	
	/**
	 * Validação Simples de vazio se server_id
	 * @param interger $valor
	 * @return boolean|string
	 */
	function vazioInteiro ($valor, $campo)
	{
		$this->_setValue($campo);
		if($valor)
			if(is_numeric($valor) && $valor > 0)	
				return true;
		$this->_error(self::DIGIT);
		return false;
	}
	
	/**
	 * Validação Simples de validação se vazio e string
	 * @param string $valor
	 * @return boolean|string
	 */
	function vazioString ($valor, $campo)
	{
		$this->_setValue($campo);
		if($valor)
			if(is_string($valor) && strlen($valor) > 2)	
				return true;
			else
				$this->_error(self::LENGHT);
		return false;
	}
	
	/**
	 * Validação de senha se vazio
	 * @param string $valor
	 * @return boolean|string
	 */
	function vazioSenha ($valor, $campo)
	{
		if(strlen($valor) < 9 && strlen($valor) > 5){			
			return true;
		}else{
			$this->_setValue($campo);
			$this->_error(self::PASSL);
		}
		return false;
	}
		
	/**
	 * Validação de Cliente para usuários
	 * @param int $valor
	 * @return boolean|string
	 */
	function validaCliente ($valor, $campo)
	{
		$this->_setValue($campo);
		if(count($valor) > 0)
			foreach($valor as $item):
				if(is_numeric($item) && $item > 0)	
					return true;
				else
					$this->_error(self::NULL);
			endforeach;
		return false;
	}
	
	
	function validaEmail ($email)
	{
		$mail_correto = false; 
		if ((strlen($email) > 5) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@"))
		{ 
			if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) 
			{ 
	         //vejo se tem caracter . 
				if (substr_count($email,".")>= 1)
				{ 
					$term_dom = substr(strrchr ($email, '.'),1);//obtenho a terminação do dominio
					 
		            //verifico que a terminação do dominio seja correcta 
					if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) )
					{ 
	            		//verifico que o de antes do dominio seja correcto 
						$antes_dom		= substr($email,0,strlen($email) - strlen($term_dom) - 1); 
						$caracter_ult	= substr($antes_dom,strlen($antes_dom)-1,1);
						 
			            if ($caracter_ult != "@" && $caracter_ult != ".")
			               $mail_correto = true; 
					} 
				} 
			} 
		}
		return $mail_correto;
	}
}