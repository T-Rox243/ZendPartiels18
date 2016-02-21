<?php
namespace Front;
return array(
    'controllers' => array(
        'invokables' => array(
            'Front\Controller\Index' => 'Front\Controller\IndexController',
            'Front\Controller\Categorie' => 'Front\Controller\CategorieController',
            'Front\Controller\Produit' => 'Front\Controller\ProduitController',
            'Front\Controller\Compte' => 'Front\Controller\CompteController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'front' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/index[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Index',
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
                        'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Categorie',
                        'action'     => 'liste',
                    ),
                ),
            ),
            'produit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/produit[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Produit',
                        'action'     => 'fiche',
                    ),
                ),
            ),
            'compte' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/compte[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Compte',
                        'action'     => 'inscription',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'front' => __DIR__ . '/../view',
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