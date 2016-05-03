<?php
namespace Users\Forms; 

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
	use Zend\Form\Element;
	use Zend\Form\Form;
	use Zend\Captcha;
	use Zend\Form\Factory;

class FormLogin extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct($name);

		$factory = new Factory();

     		$email = $factory->createElement(array(
				'name' => 'email',
				'attributes' => array(
					'type' =>'email',
					'required' => 'required',
					'placeholder' => 'Correo electronico',
					'class' => 'form-control',
				),
			));

			$password = $factory->createElement(array(
				'name' => 'password',
				'attributes' => array(
					'type' =>'password',
					'required' => 'required',
					'placeholder' => 'Contraseña',
					'class' => 'form-control',
				),
			));

			$send = $factory->createElement(array(
				'name'=>'send',
				'attributes' => array(
					'type' => 'submit',
					'value' => 'Iniciar sesion',
					'class' => 'btn btn-primary form-control'
				),

			));
			
			$this->add($email);
			$this->add($password);
			$this->add($send);

	}

}

?>