<?php
namespace Cart;

use Zend\Mvc\Router\Http\Segment;
use Cart\Controller\CartController;
use Cart\ServiceFactory\Controller\CartControllerFactory;
use Cart\Model\CartTable;
use Cart\ServiceFactory\Model\CartTableFactory;
use Cart\ServiceFactory\Storage\CartSessionContainerFactory;
use Cart\Model\CartItemTable;
use Cart\ServiceFactory\Model\CartItemTableFactory;
use Cart\Filter\CartFilter;
use Cart\Service\CartService;
use Cart\ServiceFactory\Service\CartServiceFactory;
use Cart\Service\CartItemService;
use Cart\ServiceFactory\Service\CartItemServiceFactory;

return [
    'router' => [
        'routes' => [
            'cart' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/cart[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => CartController::class,
                        'action'     => 'showCart',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            CartController::class => CartControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            CartTable::class => CartTableFactory::class,
            CartItemTable::class => CartItemTableFactory::class,

            CartService::class => CartServiceFactory::class,
            CartItemService::class => CartItemServiceFactory::class,
            
            'Cart\Storage\CartSessionContainer' => CartSessionContainerFactory::class,
        ],
        'invokables' => [
            CartFilter::class => CartFilter::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];