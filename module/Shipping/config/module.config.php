<?php
namespace Shipping;

use Zend\Mvc\Router\Http\Segment;
use Shipping\Controller\ShippingController;
use Shipping\ServiceFactory\Controller\ShippingControllerFactory;
use Shipping\Model\ShippingTable;
use Shipping\ServiceFactory\Model\ShippingTableFactory;
use Shipping\Service\ShippingService;
use Shipping\ServiceFactory\Service\ShippingServiceFactory;
use Shipping\Filter\ShippingFilter;

return [
    'router' => [
        'routes' => [
            'shipping' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/shipping[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => ShippingController::class,
                        'action'     => 'showShippingPage',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            ShippingController::class => ShippingControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            ShippingTable::class => ShippingTableFactory::class,
            
            ShippingService::class => ShippingServiceFactory::class
        ],
        'invokables' => [
            ShippingFilter::class => ShippingFilter::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];