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
use Zend\Db\Adapter\Adapter;
use Store\Model\Entity\Producto;

class ProductsController extends AbstractActionController
{
    public $dbAdapter; // adaptador de la base de datos

    /**
     * Funcion que extrae los productos de la base de datos y llama a la vista
     */
    public function listAction()
    {
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter'); // Se inicializa el adaptador para la bd

        $producto = new Producto($this->dbAdapter); // Se crea un objeto de Producto

        // Se extraen todos los productos separados en categorias
        $paninis = $producto->getByCategory('Paninis');
        $hamburguesas = $producto->getByCategory('Hamburguesas');
        $sopas = $producto->getByCategory('Sopas');
        $cremas = $producto->getByCategory('Cremas');
        $baguettes = $producto->getByCategory('Baguettes');
        $lasagnas = $producto->getByCategory('Lasagnas');
        $platillos = $producto->getByCategory('Platillos');
        $pastas = $producto->getByCategory('Pastas');
        $frutas = $producto->getByCategory('Frutas');
        $desayunos = $producto->getByCategory('Desayunos');
        $omelettes = $producto->getByCategory('Omelettes');
        $bebidas = $producto->getByCategory('Bebidas');
        //------------------------------------------------------

        $params = array(
            'paninis'       => $paninis,
            'hamburguesas'  => $hamburguesas,
            'sopas'         => $sopas,
            'cremas'        => $cremas,
            'baguettes'     => $baguettes,
            'lasagnas'      => $lasagnas,
            'platillos'     => $platillos,
            'pastas'        => $pastas,
            'frutas'        => $frutas,
            'desayunos'     => $desayunos,
            'omelettes'     => $omelettes,
            'bebidas'       => $bebidas,
        ); // Se crea el arreglo de parametros apra enviar a la vista

        return new ViewModel($params); // Se llama a la vista y se pasan los parametros
    }


     public function combo2Action()
    {
         $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter'); // Se inicializa el adaptador para la bd

        $producto = new Producto($this->dbAdapter); // Se crea un objeto de Producto

        // Se extraen todos los productos separados en categorias
        $paninis = $producto->getByCategoryCombo('Paninis');
        $sopas = $producto->getByCategoryCombo('Sopas');
        $cremas = $producto->getByCategoryCombo('Cremas');
        $baguettes = $producto->getByCategoryCombo('Baguettes');

        //------------------------------------------------------

        $params = array(
            'panini'       => $paninis,
            'sopa'         => $sopas,
            'crema'        => $cremas,
            'baguette'     => $baguettes,
        ); // Se crea el arreglo de parametros apra enviar a la vista

        return new ViewModel($params); // Se llama a la vista y se pasan los parametros
    }


    // public function addproductoAction()
    // {
    // 	$productos = $this->request->getPost('Productos');


    // 	$arreglo = array('productos'=>$productos);
    //     $jsonResult = json_encode($arreglo);
 
    //     $result = new JsonModel(array('result'=>$jsonResult));

    //     return $result;
    // }
}

