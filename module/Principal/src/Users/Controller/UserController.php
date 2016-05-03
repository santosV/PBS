<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Forms\FormLogin;
use Users\Forms\FormRegister;
use Users\Forms\FormProfile;
use Users\Model\Entity\User;
use Zend\Db\Adapter\Adapter;
use Store\Model\Entity\CustomSalad;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;
use Zend\Authentication\Result;
use Zend\Mail;

class UserController extends AbstractActionController
{
	  private $dbAdapter; //Variable de clase que corresponde al adaptador para conectarse a la base de datos

    /**
     * Metodo para inicar sesion
     */
    public function loginAction()
    {
      $auth = new AuthenticationService(); 
      $identity = $auth->getStorage()->read(); // Obtiene datos de sesion

      if($identity!=false && $identity!=null) // Pregunta si hay datos de sesion
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl()); // redireccion si es true

      $form = new FormLogin('login'); // Instancia de formulario de inicio de sesion

   		$params = array(
   			'form' => $form,
   		); // arreglo de parametros que se pasaran a la vista

   		return new ViewModel($params); // se llama a la vista y se le pasan los parametros
        
    }

    public function profileAction()
    {
      $this->dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter");
      $salad = new CustomSalad($this->dbAdapter);
      $session = new Container('user');
      $salads = $salad->getUserSalads($session->user_data['id']);
      $form = new FormProfile('update', $session->user_data);

      return new ViewModel(array('form' => $form, 'ensaladas' => $salads));
    }

    public function authAction($email = null, $password = null)
    {

      if ($this->getRequest()->isPost() || ($email != null && $password != null)) // Determinamos si se llama al metodo mediante POST
      {
          $salt = $this->getServiceLocator()->get('Config')['password_crypt']; // extrae el string de cifrado desde global
          $user_email = ($email == null) ? $this->request->getPost('email') : $email; // se extrae el correo del formulario
          $user_password = ($password == null) ? md5($salt . $this->request->getPost('password')) : md5($salt . $password); // se extrae contraseña y se cifra

          $this->dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter"); // se inicializa en db adapter

          

          $authAdapter = new AuthAdapter(
              $this->dbAdapter, // adaptador de la base de datos
              'usuarios', // tabla en la bd
              'correo', // identidad
              'password', // credencial
              ''
          ); // Se inicializa el adaptador de autenticacion

          $authAdapter->setIdentity($user_email)->setCredential($user_password); // se pasan parametros al adaptador

          $auth = new AuthenticationService(); // se crea un servicio de autenticacion

          $result = $auth->authenticate($authAdapter); // se extrae el resultado de la autenticacion

          switch ($result->getCode()) {
            case Result::FAILURE_IDENTITY_NOT_FOUND: // el correo no existe en la base de datos
              $this->flashMessenger()->addMessage('El correo no esta registrado');
              return $this->redirect()->toRoute('users-login', array('controller'=>'users', 'action'=>'login'));
              break;

            case Result::FAILURE_CREDENTIAL_INVALID: // el correo existe pero no corresponde la contraseña
              $this->flashMessenger()->addMessage('La contraseña es incorrecta');
              return $this->redirect()->toRoute('users-login', array('controller'=>'users', 'action'=>'login'));
              break;
            
            case Result::SUCCESS: // la autenticacion fue exitosa
                $storage = $auth->getStorage(); // se crea el almacenamiento de datos de identidad
                $storage->write($authAdapter->getResultRowObject(null, 'password')); // se escriben los datos
                $this->createContainer($user_email, $this->dbAdapter); // se llama al metodo que crea contenedor
                return $this->redirect()->toRoute('users-profile'); // se redirecciona al carrito de compra
              break;
          }
      }

      $this->flashMessenger()->addMessage('Ha ocurrido un error');
              return $this->redirect()->toRoute('users-login', array('controller'=>'users', 'action'=>'login'));
  
    }

    /**
     * Funcion que registra un usuario
     */
    public function registerAction()
    {
      $form = new FormRegister('register'); // Se inicializa el formulario de registro

      if ($this->getRequest()->isPost()) // Si la peticion llega mediante post
      {
          $user_email = $this->request->getPost('email'); //se obtiene el correo del formulario
          $this->dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter"); // Se inicilializa el adaptador de la db
          $usuario = new User($this->dbAdapter); // Se crea un objeto de usuario
          $bd_user = $usuario->getUsuarioByEmail($user_email); // Se extrae el usuario de la db con el email
          if($bd_user) // Si el email ya existe
          {
              $this->flashMessenger()->addMessage('Parece que su correo ya esta registrado');
              return $this->redirect()->toRoute('users-register', array('controller'=>'users', 'action'=>'register')); // Se redirecciona con un mensaje de error
          }

          else //si el email no existe en la base de datos
          {
            $user_password = $this->request->getPost('password'); // se extrae la contraseña del formulario
            $user_address = $this->request->getPost('direccion'); // direccion
            $user_name = $this->request->getPost('nombre'); // nombre
            $user_phone = $this->request->getPost('telefono'); // numero de telefono
            $salt = $this->getServiceLocator()->get('Config')['password_crypt']; // string de cifrado
            $pass_crypt = md5($salt . $user_password); // se encripta la contraseña

            $newUser = array(
                'nombre'    => $user_name,
                'correo'    => $user_email,
                'direccion' => $user_address,
                'telefono'  => $user_phone,
                'password'  => $pass_crypt,
            ); // se crea un array con los datos de usaurio que se insertaran en la base de datos

            $usuario->addUsuario($newUser); // se llama al metodo para agregar un usuario a la base de datos
            $this->authAction($user_email, $user_password);
          }
      }
      

      $params = array(
          'form' => $form,
      ); // parametros que se pasaran a la vista

      return new ViewModel($params); // se llama a la vista
    }

    /**
     * Funcion que recibe parametros para crear un contenedor de sesion
     * @param email: se utiliza para extraer ese registro de la base de datos
     * @param adapter: el adaptador para las conexiones a la base de datos
     */
    public function createContainer($email, $adapter)
    {
      $usuario = new User($adapter); // se instancia un objeto del modelo User
      $current_user = $usuario->getUsuarioByEmail($email); // Se obtiene un registro de la bd con el email
      $user_session = new Container('user'); // Se crea un contenedor de datos para la session
      $user_session->user_data = $current_user; // Se almacena el id del usuario en el contenedor

    }

    /**
     * Funcion para cerrar la sesion de usuario
     */
    public function logoutAction(){
        $auth = new AuthenticationService(); //Se crear el objeto de autenticacion
        $auth->clearIdentity(); // Se eliminan las variables de sesion del objeto
        $session = new Container('user'); // Se llama al contenedor de datos de usuario
        $session->getManager()->getStorage()->clear('user'); // Se vacia el contenedor
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/user-login'); // redirecciona a login
    }

    public function updateAction()
    {
      if ($this->getRequest()->isPost())
      {
        $session = new Container('user');
        $name = $this->request->getPost('nombre');
        $direccion = $this->request->getPost('direccion');
        $telefono = $this->request->getPost('telefono');

        $this->dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter");
        $user = new User($this->dbAdapter);
        $user->updateUsuario($session->user_data['id'], array('nombre' => $name, 
                                                              'direccion' => $direccion, 
                                                              'telefono' => $telefono));
        $session->user_data['nombre'] = $name;
        $session->user_data['direccion'] = $direccion;
        $session->user_data['telefono'] = $telefono;

        $this->flashMessenger()->addMessage('Sus datos han sido actualizados');
        return $this->redirect()->toRoute('users-profile', array('controller'=>'users', 'action'=>'profile'));
      }
    }

    // public function confirmAction()
    // {
    //   echo $this->params()->fromRoute('key');
    // }

    // public function sendemailAction()
    // {
    //   $mail = new Mail\Message();
    //   $mail->setBody('Gracias por registrarte con nosotros, tu codigo de confirmacion es: 122234');
    //   $mail->setFrom('noreply@bajasalads.com', 'Baja Salads Deli Express');
    //   $mail->addTo('christian.ibarra931@gmail.com', 'Christian');
    //   $mail->setSubject('Confirmación de correo');

    //   $transport = new Mail\Transport\Sendmail();
    //   $transport->send($mail);
    // }
}
