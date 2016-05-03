<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Store\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\Adapter\Adapter;
use Store\Model\Entity\Ingrediente;
use Store\Model\Entity\CustomSalad;
use Store\Model\Entity\Producto;
use Store\Model\Entity\Combo;
use Store\Controller\CarController;
use Zend\Session\Container;

class SaladsController extends AbstractActionController
{

	public $dbAdapter; // adaptador de bases de datos
    public $session; // datos de sesion

    public function __construct()
    {
        $this->session = new Container('user'); // Se llama a los datos de sesion
    }
    /**
     * Funcion que extrae los ingredientes necesarios para crear una ensalada
     */
    public function createAction()
    {
    	$this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');

        //Se extraen los ingredientes de la base de datos
    	$ingrediente = new Ingrediente($this->dbAdapter);
    	$porciones = $ingrediente->getByCategory('Porcion');
        $pollo_marisco = $ingrediente->getByCategory('PolloMarisco');
        $barra_fria = $ingrediente->getByCategory('BarraFria');
        $aderezo = $ingrediente->getByCategory('Aderezo');
        $extra = $ingrediente->getByCategory('Extras');

        //Se genera el arreglo que se envia como parametro para ser trabajado en la vista index
        $params = array(
            'porciones'=>$porciones,
            'pollo_marisco' => $pollo_marisco,
            'barra_fria' => $barra_fria,
            'aderezo' => $aderezo,
            'extra' => $extra,
            'saludo' => 'Hola desde el controller'
            );
        return new ViewModel($params);
    }

    public function comboAction()
    {
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');

        $producto = new Producto($this->dbAdapter);
        $paninis = $producto->getByCategory('Paninis');
        $sopas = $producto->getByCategory('Sopas');
        $cremas = $producto->getByCategory('Cremas');
        $baguettes = $producto->getByCategory('Baguettes');

        $params = array(
            'paninis'       => $paninis,
            'sopas'         => $sopas,
            'cremas'        => $cremas,
            'baguettes'     => $baguettes,
        );

        return new ViewModel($params);
    }

    /**
     * Funcion que agrega ensalada a la base de datos
     */
    public function addsaladAction()
    {
    	$this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
    	//Se extraen los parametros POST necesarios para agregar una nueva ensalada
    	$nombre = $this->request->getPost('nombre');
        $ingredientes = $this->request->getPost('idingredientes');
        $comentarios = $this->request->getPost('comentarios');
        $cantidad = $this->request->getPost('cantidad');
        $is_combo = $this->request->getPost("is_combo");
        $salad_size = $this->request->getPost("salad_size");
        //------------------------------------------------------------------------
        $salad_price = 0.0;
        switch ($salad_size) {
            case 'C':
                $salad_price = 85.0;
                break;
            case 'M':
                $salad_price = 95.0;
                break;
            case 'G':
                $salad_price = 120.0;
                break;
            
            default:
                $salad_price = 85.0;
                break;
        }

       	$customSalad = new CustomSalad($this->dbAdapter); // se crea objeto de la tabla custom salad.
        $carrito = new CarController(); // Se crea un objeto del controlador carrito de compra
       	$newSalad = array(
                            'nombre'=>$nombre, 
                            'usuario' => $this->session->user_data['id'], 
                            'comentarios'=>$comentarios, 
                            'precio' => $salad_price,
                        ); // se crea la nueva ensalada.
       	$currentID = $customSalad->addCustomSalad($newSalad); // se llama al metodo para insertar la ensalada creada

       	foreach ($ingredientes as $ing) { // Por cada ingrediente
        	$this->dbAdapter->query('CALL nuevaEnsalada('.(int)$currentID.','.(int)$ing.','. $this->session->user_data['id'] .');', Adapter::QUERY_MODE_EXECUTE); // llama al procedimiento almacenado que crea relacion ensalada-ingrediente
        }

        if($is_combo == 'true')
        {
            $combo_producto = $this->request->getPost("id_producto");
            $combo = new Combo($this->dbAdapter);
            $currentCombo = $combo->addCombo(array('ensalada' => $currentID));
            $this->dbAdapter->query('insert into combo_productos (combo, producto) values (
                                    '. $currentCombo .', '. $combo_producto .')', Adapter::QUERY_MODE_EXECUTE);
            $carrito->addCombo($currentCombo, 1, $this->dbAdapter);
        }
        else 
        {
        $carrito->addSalad($currentID, $cantidad, $this->dbAdapter); // se llama al metodo que agrega la ensalada actual al carrito
        }

        return true;
    }

    public function deleteAction()
    {
        $this->dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter");
        if ($this->getRequest()->isPost())
        {
            $id = base64_decode(base64_decode($this->request->getPost("id")));
            $user = $this->session->user_data['id'];

            $ensalada = new CustomSalad($this->dbAdapter);
            $ensalada->deleteCustomSalad($id, $user);

            return true;
        }
        return false;
    }

    public function newcomboAction()
    {   
        $this->dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter");
        // print_r($this->dbAdapter);
        if ($this->getRequest()->isPost()) {

            $p1 = $this->request->getPost("p1");
            $p2 = $this->request->getPost("p2");

            $combo = new Combo($this->dbAdapter);
            $currentCombo = $combo->addCombo(array('ensalada' => 0));

            $this->dbAdapter->query('insert into combo_productos (combo, producto) values (
                                    '. $currentCombo .', '. (int)$p1 .')', Adapter::QUERY_MODE_EXECUTE);
            $this->dbAdapter->query('insert into combo_productos (combo, producto) values (
                                    '. $currentCombo .', '. (int)$p2 .')', Adapter::QUERY_MODE_EXECUTE);

            $carrito = new CarController();
            $carrito->addCombo($currentCombo, 1, $this->dbAdapter);

            return true;
       }
       return false;
    }
}
