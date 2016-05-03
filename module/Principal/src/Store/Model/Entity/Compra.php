<?php 

namespace Store\Model\Entity;

use Zend\Db\TableGateway\TableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\Resultset\Resultset;

class Compra extends TableGateway
{
	 public function __construct(Adapter $adapter = null, $dataBaseSchema = null, Resultset $selectResultPrototype = null)
	 {
	 	return parent::__construct('compras', $adapter, $dataBaseSchema, $selectResultPrototype);
	 }

	 public function addCompra($compra = array())
	 {
	 	$this->insert($compra);
	 	return $this->lastInsertValue;
	 }
	 
}
