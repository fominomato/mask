<?php
/**
 * Classe para validação de formulario de aplicação
 * @author guarient
 *
 */

class App_Plugins_Valid_Product extends Zend_Validate_Abstract
{
	const LENGTH = 'length';
	const DUPLIC = 'duplic';
	
	protected $_messageTemplates = array(
		self::LENGTH 	=> "<div class='error'>'%value%' quantidade de caracteres deverá ser entre 2 e 100.</div>",
		self::DUPLIC 	=> "<div class='error'>Entrada em duplicidade.</div>"
		);
	
	public function isValid($valor)
	{
		if(self::vazioString($valor['title'], 'Título do produto') == false)
			return false;
		
		return true;
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
			if(is_string($valor) && strlen($valor) > 1 && strlen($valor) < 100)	
				return true;
			else
				$this->_error(self::LENGHT);
		return false;
	}
	
	/**
	 * Validação de duplicidade de entrada
	 * @param array $valor
	 * @param string $campo
	 * @return boolean|string
	 */
	function duplicidade ($valor, $campo)
	{
		$this->_setValue($campo);
		$mapper = new Application_Model_ProductMapper();
		$rsOut	= $mapper->fetchall($valor);
		if(count($rsOut) > 0 && is_array($rsOut))
		{
			$this->_error(self::DUPLIC);
			return false;
		}
		return true;
	}
	
}