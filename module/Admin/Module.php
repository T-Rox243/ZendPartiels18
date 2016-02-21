<?php

namespace Admin;

use Admin\Model\ProduitTable;
use Admin\Model\UtilisateurTable;
use Admin\Model\CategorieTable;
use Admin\Model\CategProdTable;
use Admin\Model\CaracteristiqueTable;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Admin\Model\ProduitTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ProduitTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\UtilisateurTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UtilisateurTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\CategorieTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CategorieTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\CategProdTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CategProdTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\CaracteristiqueTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CaracteristiqueTable($dbAdapter);
                    return $table;
                },
            ),
        );
    }    

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}