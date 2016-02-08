<?php

namespace Produit\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class ProduitTable extends AbstractTableGateway
{
    protected $table = 'produit';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Produit());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getProduit($id_prod)
    {
        $id_prod  = (int) $id_prod;
        $rowset = $this->select(array('id_prod' => $id_prod));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id_prod");
        }
        return $row;
    }

    public function saveProduit(Produit $produit)
    {
        $data = array(
            'nom' => $produit->nom,
            'reference'  => $produit->reference,
            'description'  => $produit->description,
            'url_img'  => $produit->url_img,
            'prix'  => $produit->prix,
            'bl_archive'  => $produit->bl_archive,
            'bl_nouv'  => $produit->bl_nouv,
            'bl_best'  => $produit->bl_best,
        );

        $id_prod = (int)$produit->id_prod;
        if ($id_prod == 0) {
            $this->insert($data);
        } else {
            if ($this->getProduit($id_prod)) {
                $this->update($data, array('id_prod' => $id_prod));
            } else {
                throw new \Exception('Form id_prod does not exist');
            }
        }
    }

    public function deleteProduit($id_prod)
    {
        $this->delete(array('id_prod' => $id_prod));
    }

}
