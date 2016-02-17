<?php
namespace Admin;
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Produit' => 'Admin\Controller\ProduitController',
            'Admin\Controller\Categorie' => 'Admin\Controller\CategorieController',
            'Admin\Controller\Utilisateur' => 'Admin\Controller\UtilisateurController',
            'Admin\Controller\Categorie' => 'Admin\Controller\CategorieController',
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'produit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/produit[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Produit',
                        'action'     => 'index',
                    ),
                ),
            ),
            'index' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/index[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'utilisateur' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/utilisateur[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Utilisateur',
                        'action'     => 'index',
                    ),
                ),
            ),
            'categorie' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/categorie[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Categorie',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
);