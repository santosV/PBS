<?php 

namespace Store\Model\Entity;

use Zend\Db\TableGateway\TableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Resultset\Resultset;

class Producto extends TableGateway
{
	 public function __construct(Adapter $adapter = null, $dataBaseSchema = null, Resultset $selectResultPrototype = null)
	 {
	 	return parent::__construct('productos', $adapter, $dataBaseSchema, $selectResultPrototype);
	 }

	 public function getAll()
	 {
	 	$resultSet = $this->select();
	 	return $resultSet->toArray();
	 }
	 public function getProducto($id)
	 {
	 	$id = (int) $id;
	 	$rowset = $this->select(array('id'=>$id));
	 	$row = $rowset->current();
	 	if(!$row)
	 	{
	 		throw new \Exception("No existe ningun registro con el id $id");
	 	}

	 	return $row;
	 }

	 public function getByCategory($categoria){
	 	$resultSet = $this->select(array('categoria' => $categoria));
	 	return $resultSet->toArray();
	 }

	 public function getByCategoryCombo($categoria){
	 	$resultSet = $this->select(array('categoria' => $categoria, 'combo' => 1));
	 	return $resultSet->toArray();
	 }

	 public function addProducto($producto = array())
	 {
	 	$this->insert($producto);
	 }

	 public function updateProducto($id, $producto)
	 {
	 	$this->update($producto, array('id' => $id));
	 }

	 public function deleteProducto($id)
	 {
	 	$this->delete(array('id'=>$id));
	 }
	 
}
