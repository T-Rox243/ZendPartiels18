<?php

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class CaracteristiqueTable extends AbstractTableGateway
{
    protected $table = 'caracteristique';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Caracteristique());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getCaracteristique($id_cara)
    {
        $id_cara  = (int) $id_cara;
        $rowset = $this->select(array('id_cara' => $id_cara));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id_cara");
        }
        return $row;
    }

    public function saveCaracteristique(Caracteristique $caracteristique)
    {
        $data = array(
            'nom' => $caracteristique->nom,
            'url_img'  => $caracteristique->url_img,
            'description'  => $caracteristique->description,
        );

        $id_cara = (int)$caracteristique->id_cara;
        if ($id_cara == 0) {
            $this->insert($data);
        } else {
            if ($this->getCaracteristique($id_cara)) {
                $this->update($data, array('id_cara' => $id_cara));
            } else {
                throw new \Exception('Form id_cara does not exist');
            }
        }
    }

    public function deleteCaracteristique($id_cara)
    {
        $this->delete(array('id_cara' => $id_cara));
    }

}
