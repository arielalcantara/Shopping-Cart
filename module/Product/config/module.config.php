<?php
namespace Product;

use Zend\Mvc\Router\Http\Segment;
use Product\Controller\ProductController;
use Product\ServiceFactory\Controller\ProductControllerFactory;
use Product\Model\ProductTable;
use Product\ServiceFactory\Model\ProductTableFactory;
use Product\Service\ProductService;
use Product\ServiceFactory\Service\ProductServiceFactory;

return [
    'router' => [
        'routes' => [
            'product' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/product[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => ProductController::class,
                        'action'     => 'showAllProducts',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            ProductController::class => ProductControllerFactory::class,
        ],
    ],
   'service_manager' => [
       'factories' => [
            ProductTable::class => ProductTableFactory::class,
            
            ProductService::class => ProductServiceFactory::class
       ],
       'invokables' => [

       ]
   ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];