<?php
namespace Users\Forms; 

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
	use Zend\Form\Element;
	use Zend\Form\Form;
	use Zend\Captcha;
	use Zend\Form\Factory;

class FormProfile extends Form 
{

	public function __construct($name = null, $user_data)
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
					'value' => $user_data['nombre']
				),
			));

			$telefono = $factory->createElement(array(
				'name' => 'telefono',
				'attributes' => array(
					'type' =>'tel',
					'required' => 'required',
					'placeholder' => 'Teléfono',
					'class' => 'form-control',
					'value' => $user_data['telefono']
				),
			));

			$direccion = $factory->createElement(array(
				'name' => 'direccion',
				'attributes' => array(
					'type' =>'text',
					'required' => 'required',
					'placeholder' => 'Dirección',
					'class' => 'form-control',
					'value' => $user_data['direccion']
				),
			));

			$send = $factory->createElement(array(
				'name'=>'send',
				'attributes' => array(
					'type' => 'submit',
					'value' => 'Actualizar información',
					'class' => 'btn btn-success btn-block',
					'id' => 'btnUpdate',
				),

			));
			
			$this->add($nombre);
			$this->add($telefono);
			$this->add($direccion);
			$this->add($send);

	}

}

?>