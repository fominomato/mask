<?php
/**
 * Classe para validação de formulario de aplicação
 * @author guarient
 *
 */

class App_Plugins_Valid_Component extends Zend_Validate_Abstract
{

    const SERVR = 'servr';
    const TITLE = 'title';
    const TAMAN = 'taman';
    
	protected $_messageTemplates = array(
		self::TAMAN 	=> "<div class='error'>O campo '%value%', deverá ter entre 2 e 100 cracteres.</div>",
		self::TITLE		=> "<div class='error'>O campo '%value%' não foi encontrado.</div>",
		self::SERVR		=> "<div class='error'>O campo '%value%' é inválido.</div>"
	);
	
	public function isValid($valor)
	{

		if(trim($valor['title']) == "" || empty($valor['title']) || strlen($valor['title']) < 2){
			$this->_setValue('título');
			$this->_error(self::TAMAN);
			return false;
		}
		
//		if($valor['server_id'] < 1 || empty($valor['server_id'])){
//			$this->_setValue('servidor');
//			$this->_error(self::SERVR);
//			return false;
//		}		

		return true;
	}
}