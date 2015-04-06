<?php

class Login extends Zend_Form
{
	public function init()
	{
		$this->setName('login');

		$login = new Zend_Form_Element_Text('login');
		$login->setLabel('Login')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->setAttrib('class', 'inptLogin')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
			  
		$passwd = new Zend_Form_Element_Password('passwd');
		$passwd->setLabel('Senha')
			  ->setRequired(true)
			  ->setAttrib('class', 'inptLogin')
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
			  
			  
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Logar')
			   ->setAttrib('id', 'submitbutton')
			   ->setAttrib('class', 'btLogin');

		$this->addElements(array($login, $passwd, $submit));
	}
}
