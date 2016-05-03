<?php 

namespace Store\Model\Entity;

use Zend\Db\TableGateway\TableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Resultset\Resultset;

class Ingrediente extends TableGateway
{
	 public function __construct(Adapter $adapter = null, $dataBaseSchema = null, Resultset $selectResultPrototype = null)
	 {
	 	return parent::__construct('ingredientes', $adapter, $dataBaseSchema, $selectResultPrototype);
	 }

	 public function getAll()
	 {
	 	$resultSet = $this->select();
	 	return $resultSet->toArray();
	 }
	 public function getIngrediente($id)
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

	 public function addIngrediente($ingrediente = array())
	 {
	 	$this->insert($ingrediente);
	 }

	 public function updateIngrediente($id, $ingrediente)
	 {
	 	$this->update($ingrediente, array('id' => $id));
	 }

	 public function deleteIngrediente($id)
	 {
	 	$this->delete(array('id'=>$id));
	 }
	 
}
