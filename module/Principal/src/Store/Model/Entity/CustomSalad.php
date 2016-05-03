<?php 

namespace Store\Model\Entity;

use Zend\Db\TableGateway\TableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Resultset\Resultset;

class CustomSalad extends TableGateway
{
	 public function __construct(Adapter $adapter = null, $dataBaseSchema = null, Resultset $selectResultPrototype = null)
	 {
	 	return parent::__construct('ensaladas', $adapter, $dataBaseSchema, $selectResultPrototype);
	 }

	 public function getAll()
	 {
	 	$resultSet = $this->select();
	 	return $resultSet->toArray();
	 }
	 public function getCustomSalad($id)
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

	 public function getCustomSaladByParams($idUsuario, $nombre)
	 {
	 	$id = (int) $idUsuario;
	 	$rowset = $this->select(array('usuario'=>$id, 'nombre'=>$nombre));
	 	$row = $rowset->current();
	 	if(!$row)
	 	{
	 		throw new \Exception("No existe ningun registro");
	 	}

	 	return $row;
	 }

	 public function getUserSalads($idUsuario)
	 {
	 	$resultSet = $this->select(array('usuario' => $idUsuario));
	 	return $resultSet->toArray();
	 }

	 public function addCustomSalad($ensalada = array())
	 {
	 	$this->insert($ensalada);
	 	return $this->lastInsertValue;
	 }

	 public function updateCustomSalad($id, $ensalada)
	 {
	 	$this->update($ensalada, array('id' => $id));
	 }

	 public function deleteCustomSalad($id, $user)
	 {
	 	$this->delete(array('id'=>$id, 'usuario' => $user));
	 }
	 
}
