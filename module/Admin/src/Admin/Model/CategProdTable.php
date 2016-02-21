<?php

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class CategProdTable extends AbstractTableGateway
{
    protected $table = 'categ_prod';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new CategProd());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getListIdProd($id_categ)
    {
        $id_categ  = (int) $id_categ;
        $rowset = $this->select(array('id_categ' => $id_categ));
        $row = $rowset->execute();
        if (!$row) {
            throw new \Exception("Could not find row $id_categ");
        }
        return $row;
    }

}
