<?php
/**
 * Classe para validação de formulario de aplicação
 * @author guarient
 *
 */

class App_Plugins_Valid_Application extends Zend_Validate_Abstract
{

	const LENGTH = 'length';
    const DIGIT  = 'digit';
    const NULL   = 'null';
    const ENVRM  = 'envrm';
    
	protected $_messageTemplates = array(
		self::LENGTH 	=> "<div class='error'>'%value%' quantidade de caracteres insuficiente.</div>",
		self::ENVRM 	=> "<div class='error'>O campo '%value%' não esta presente.</div>",
		self::NULL		=> "<div class='error'>O campo '%value%' não foi encontrado.</div>",
		self::DIGIT  	=> "<div class='error'>O campo '%value%' campo não pode ser nulo.</div>"
	);
	
	public function isValid($valor)
	{
	
		if($valor['component_id'] && self::vazioInteiro($valor['component_id'], 'Componente') == false)
			$isValid = false;
		else if(!$valor['component_id'] || empty($valor['component_id'])){
			$this->_setValue('componente');
			$this->_error(self::NULL);
			return false;
		}
		
		if(strlen($valor['name']) < 2 && self::vazioInteiro($valor['application_id'], 'Aplicacao') == false)
			return false;
			
		if($valor['name'])
			if(self::vazioString($valor['name'], 'Nome da aplicacao') == false)
				return false;
		
		if(!$valor['ambient_id'] && ($valor['ambient_id'] < 1))
		{
			$this->_setValue("Ambiente");
			$this->_error(self::ENVRM);
		}
	
		return true;
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
			if(is_string($valor) && strlen($valor) > 1)	
				return true;
			else
				$this->_error(self::LENGHT);
		return false;
	}
}