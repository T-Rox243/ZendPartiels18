<?php

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class UtilisateurTable extends AbstractTableGateway
{
    protected $table = 'utilisateur';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Utilisateur());

        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getUtilisateur($id_util)
    {
        $id_util  = (int) $id_util;
        $rowset = $this->select(array('id_util' => $id_util));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id_util");
        }
        return $row;
    }

    public function saveUtilisateur(Utilisateur $utilisateur)
    {
        $data = array(
            'nom' => $utilisateur->nom,
            'prenom'  => $utilisateur->prenom,
            'email'  => $utilisateur->email,
            'bl_acti'  => $utilisateur->bl_acti,
        );

        $id_util = (int)$utilisateur->id_util;
        if ($id_util == 0) {
            $this->insert($data);
        } else {
            if ($this->getUtilisateur($id_util)) {
                $this->update($data, array('id_util' => $id_util));
            } else {
                throw new \Exception('Form id_util does not exist');
            }
        }
    }

    public function deleteUtilisateur($id_util)
    {
        $this->delete(array('id_util' => $id_util));
    }

}
