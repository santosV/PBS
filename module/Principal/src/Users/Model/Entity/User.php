<?php 

namespace Users\Model\Entity;

use Zend\Db\TableGateway\TableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Resultset\Resultset;

class User extends TableGateway
{
	 public function __construct(Adapter $adapter = null, $dataBaseSchema = null, Resultset $selectResultPrototype = null)
	 {
	 	return parent::__construct('usuarios', $adapter, $dataBaseSchema, $selectResultPrototype);
	 }

	 public function getAll()
	 {
	 	$resultSet = $this->select();
	 	return $resultSet->toArray();
	 }
	 public function getUsuario($id)
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

	 public function getUsuarioByEmail($email)
	 {
	 	$email = $email;
	 	$rowset = $this->select(array('correo'=>$email));
	 	$row = $rowset->current();
	 	if(!$row)
	 	{
	 		return false;// throw new \Exception("No existe ningun registro");
	 	}

	 	return $row;
	 }

	 public function addUsuario($usuario = array())
	 {
	 	$this->insert($usuario);
	 	return $this->lastInsertValue;
	 }

	 public function updateUsuario($id, $usuario)
	 {
	 	$this->update($usuario, array('id' => $id));
	 }

	 public function deleteUsuario($id)
	 {
	 	$this->delete(array('id'=>$id));
	 }
	 
}
