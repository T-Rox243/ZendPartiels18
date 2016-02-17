<?php

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class CategorieTable extends AbstractTableGateway
{
    protected $table = 'categorie';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Categorie());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getCategorie($id_categ)
    {
        $id_categ  = (int) $id_categ;
        $rowset = $this->select(array('id_categ' => $id_categ));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id_categ");
        }
        return $row;
    }

    public function saveCategorie(Categorie $categorie)
    {
        $data = array(
            'nom' => $categorie->nom,
            'url_img'  => $categorie->url_img,
            'description'  => $categorie->description,
        );

        $id_categ = (int)$categorie->id_categ;
        if ($id_categ == 0) {
            $this->insert($data);
        } else {
            if ($this->getCategorie($id_categ)) {
                $this->update($data, array('id_categ' => $id_categ));
            } else {
                throw new \Exception('Form id_categ does not exist');
            }
        }
    }

    public function deleteCategorie($id_categ)
    {
        $this->delete(array('id_categ' => $id_categ));
    }

}
