<?php
namespace Users\Forms; 

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
	use Zend\Form\Element;
	use Zend\Form\Form;
	use Zend\Captcha;
	use Zend\Form\Factory;

class FormRegister extends Form 
{
	public function __construct($name = null)
	{
		parent::__construct($name);

		$factory = new Factory();

			$nombre = $factory->createElement(array(
				'name' => 'nombre',
				'attributes' => array(
					'type' =>'text',
					'required' => 'required',
					'placeholder' => 'Nombre',
					'class' => 'form-control',
				),
			));

			$telefono = $factory->createElement(array(
				'name' => 'telefono',
				'attributes' => array(
					'type' =>'tel',
					'required' => 'required',
					'placeholder' => 'Teléfono',
					'class' => 'form-control',
				),
			));

			$direccion = $factory->createElement(array(
				'name' => 'direccion',
				'attributes' => array(
					'type' =>'text',
					'required' => 'required',
					'placeholder' => 'Dirección',
					'class' => 'form-control',
				),
			));

     		$email = $factory->createElement(array(
				'name' => 'email',
				'attributes' => array(
					'type' =>'email',
					'required' => 'required',
					'placeholder' => 'example@example.com',
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
					'id' => 'pass1',
				),
			));

			$password_repeat = $factory->createElement(array(
				'name' => 'password_repeat',
				'attributes' => array(
					'type' =>'password',
					'required' => 'required',
					'placeholder' => 'Repita la contraseña',
					'class' => 'form-control',
					'id' => 'pass2',
				),
			));

			$send = $factory->createElement(array(
				'name'=>'send',
				'attributes' => array(
					'type' => 'submit',
					'value' => 'Registrar',
					'class' => 'btn btn-success btn-block',
					'id' => 'btnRegister',
				),

			));
			
			$this->add($email);
			$this->add($password);
			$this->add($nombre);
			$this->add($telefono);
			$this->add($direccion);
			$this->add($password_repeat);
			$this->add($send);

	}

}

?>