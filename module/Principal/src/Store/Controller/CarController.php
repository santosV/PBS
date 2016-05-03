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
use Store\Model\Entity\CEnsalada;
use Store\Model\Entity\CProducto;
use Store\Model\Entity\CCombo;
use Store\Model\Entity\Combo;
use Zend\Session\Container;
use Store\Model\Entity\Compra;

class CarController extends AbstractActionController
{
	public $dbAdapter; // adaptador de bases de datos
    public $session; // session actual

    public function __construct()
    {
        $this->session = new Container('user');// Extrae datos de session
    }

    /**
     * Funcion que carga el carrito de compra desde la bd
     */
    public function viewAction()
    {

    	$this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter'); // inicaliza el adaptador de la bd
        $ensaladas = $this->dbAdapter->query('select carrito_ensalada.id, nombre, precio, cantidad from carrito_ensalada inner join ensaladas on ensaladas.id = ensalada and carrito_ensalada.usuario ='. $this->session->user_data['id'], Adapter::QUERY_MODE_EXECUTE); // Extrae el carrito de ensaladas del usuario actual

        $productos = $this->dbAdapter->query('select carrito_producto.id, nombre, precio, cantidad from carrito_producto inner join productos on productos.id = producto and carrito_producto.usuario ='. $this->session->user_data['id'], Adapter::QUERY_MODE_EXECUTE); // Extrae el carrito de productos del usuario actual

        $combos = $this->dbAdapter->query('select carrito_combo.id, "combo" as nombre, precio, cantidad from carrito_combo inner join combos on combos.id = combo and carrito_combo.usuario =' . $this->session->user_data['id'], Adapter::QUERY_MODE_EXECUTE);

        $total = $this->getTotal(); // llama al metodo total

        $parametros = array(
            'ensaladas' => $ensaladas,
            'productos' => $productos,
            'combos'    => $combos,
            'total' => $total,
        ); // arreglo de parametros que se enviaran a la vista

        return new ViewModel($parametros); // llama a la vista y envia los parametros
    }

    /**
     * Funcion encargada de agregar una ensalada al carrito de compra
     * @param id: el id de la ensalada
     * @param cantidad: cuantas ensaladas con ese id se agregaran al carrito
     * @param adapter: adaptador para conexion a la base de datos
     */
    public function addSalad($id, $cantidad, $adapter)
    {
        $newItem = array(
            'usuario' => $this->session->user_data['id'], // usuario en la sesion
            'ensalada' => $id, //id ensalada
            'cantidad' => $cantidad, // cantidad de ensaladas con ese id
        ); // se crea un array con los datos que se insertaran en la base de datos

        $c_ensalada = new CEnsalada($adapter); // se crea un objeto del modelo CEnsalada
        $c_ensalada->addItem($newItem); // se llama al metodo para agregar un registro al carrito de ensaladas
    }

    /**
     * Funcion para agregar elementos al carrito de productos
     */
    public function additemAction()
    {
        $this->dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter"); // inicializa el adaptador de bd
        $productos = $this->request->getPost('productos'); // Se obtiene el arreglo de productos desde POST

        $car_pro = new CProducto($this->dbAdapter); // se instancia un objeto del modelo CProducto

        foreach($productos as $producto) // Por cada elemento del arreglo productos
        {
            $newItem = array(
                'usuario'   => $this->session->user_data['id'], // usuario actual
                'producto'  => base64_decode(base64_decode($producto['id'])), // producto actual del arreglo productos
                'cantidad'  => (int)$producto['cantidad'], // cantidad del producto actual
            ); // Se genera un array para insertar en la bd

            $car_pro->addItem($newItem); // Se llama al metodo para agregar un registro al carrito de productos
        }


        $arreglo = array('resultado' => 'Exito'); 
        $jsonResult = json_encode($arreglo);
 
        $result = new JsonModel(array('result'=>$jsonResult));

        return $result;
    }

    public function addCombo($id, $cantidad, $adapter)
    {
        $newItem = array(
            'usuario'   => $this->session->user_data['id'],
            'combo'     => $id,
            'cantidad'  => $cantidad,
        );
        $c_combo = new CCombo($adapter);
        $c_combo->addItem($newItem);
    }

    /**
     * Funcion para eliminar un registro del carrito de compras
     */
    public function deleteAction()
    {
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter'); // Se inicaliza el adaptador de la bd
        $type = base64_decode(base64_decode($this->request->getPost('type'))); // Se obtiene mediante POST el tipo (Ensalada o Producto)
        $id = base64_decode(base64_decode($this->request->getPost('id'))); // Se obtiene mediante POST el id del elemento
        $tipo = 'indefinido'; 

        if($type == 'E') // Si es una ensalada
        {
            $c_ensalada = new CEnsalada($this->dbAdapter); // Se crea un objeto de CEnsalada
            $c_ensalada->deleteItem($id, $this->session->user_data['id']); // Se llama al metodo que elimina el registro en la bd
        }
        if ($type == 'P') // Si es un producto
        {
            $c_producto = new CProducto($this->dbAdapter); // Se crea un objeto de CProducto
            $c_producto->deleteItem($id, $this->session->user_data['id']); // Se llama al metodo que elimina el registro en la bd
        }

        if($type == 'C')
        {
            $c_combo = new CCombo($this->dbAdapter);
            $c_combo->deleteItem($id, $this->session->user_data['id']);
        }

        $arreglo = array('resultado' => 'Exito'); 
        $jsonResult = json_encode($arreglo);
 
        $result = new JsonModel(array('result'=>$jsonResult));

        return $result;
    }

    /**
     * Funcion que obtiene el total del carrito de un usuario
     * @return total: el total del valor de los productos y ensladas que tiene el usuario en la base de datos
     */
    public function getTotal()
    {
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter'); // Se inicaliza el adaptador de la base de datos
        $total_request = $this->dbAdapter->query('call total_carrito('. $this->session->user_data['id'] .')', Adapter::QUERY_MODE_EXECUTE);//Se llama un procedimiento almacenado que calcula el total, pasando como parametro el id del usurio
        $total = $total_request->current(); // se obtiene un unico registro que es el total
        return $total; 
    }

    public function addexistingsaladAction()
    {
        //print_r($this->session->user_data['id']);
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
        //print_r($this->dbAdapter);
        if ($this->getRequest()->isPost()) {
            //$this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
            $salad_id = base64_decode(base64_decode($this->request->getPost('id')));
            $salad_cant = $this->request->getPost('cantidad');
            $this->addSalad($salad_id, $salad_cant, $this->dbAdapter);

            return true;
        }
    }

    public function payAction()
    {
        if ($this->getRequest()->isPost()) 
        {
            $this->dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter");
            $compra = new Compra($this->dbAdapter);
            $total = (double) $this->getTotal()['total'];
            $newCompra = array(
                            'total'     => $total,
                            'status'    => 1,
                            'usuario'   => $this->session->user_data['id'],
                        );
            $current = $compra->addCompra($newCompra);
            $this->dbAdapter->query('call pagar('. $this->session->user_data['id'] . ', '. $current .')', Adapter::QUERY_MODE_EXECUTE);
                return true;
        }
    }
}
