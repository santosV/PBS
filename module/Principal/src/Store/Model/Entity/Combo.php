<?php 

namespace Store\Model\Entity;

use Zend\Db\TableGateway\TableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Resultset\Resultset;

class Combo extends TableGateway
{
	 public function __construct(Adapter $adapter = null, $dataBaseSchema = null, Resultset $selectResultPrototype = null)
	 {
	 	return parent::__construct('combos', $adapter, $dataBaseSchema, $selectResultPrototype);
	 }

	 public function getAll()
	 {
	 	$resultSet = $this->select();
	 	return $resultSet->toArray();
	 }
	 public function getCombo($id)
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

	 public function addCombo($combo = array())
	 {
	 	$this->insert($combo);
	 	return $this->lastInsertValue;
	 }

	 public function updateCombo($id, $combo)
	 {
	 	$this->update($combo, array('id' => $id));
	 }

	 public function deleteCombo($id)
	 {
	 	$this->delete(array('id'=>$id));
	 }
	 
}
