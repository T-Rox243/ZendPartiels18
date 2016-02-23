<?php

namespace Front\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class ListeTable extends AbstractTableGateway
{
    protected $table = 'liste';

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

    public function getListe($id_liste)
    {
        $id_liste  = (int) $id_liste;
        $rowset = $this->select(array('id_liste' => $id_liste));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id_liste");
        }
        return $row;
    }

    public function saveProduit(Liste $liste)
    {
        $data = array(
            'nom' => $liste->nom,
            'id_util' => $liste->id_util,
        );

        $id_liste = (int)$liste->id_liste;
        if ($id_liste == 0) {
            $this->insert($data);
        } else {
            if ($this->getListe($id_liste)) {
                $this->update($data, array('id_liste' => $id_liste));
            } else {
                throw new \Exception('Form id_liste does not exist');
            }
        }
    }

    public function deleteProduit($id_prod)
    {
        $this->delete(array('id_liste' => $id_liste));
    }

}
