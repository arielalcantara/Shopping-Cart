<?php
namespace Payment;

use Zend\Mvc\Router\Http\Segment;
use Payment\Controller\PaymentController;
use Payment\ServiceFactory\Controller\PaymentControllerFactory;
use Payment\Model\PaymentTable;
use Payment\ServiceFactory\Model\PaymentTableFactory;
use Payment\Service\PaymentService;
use Payment\ServiceFactory\Service\PaymentServiceFactory;
use Payment\Filter\PaymentFilter;

return [
    'router' => [
        'routes' => [
            'payment' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/payment[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => PaymentController::class,
                        'action'     => 'showPaymentPage',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            PaymentController::class => PaymentControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            PaymentTable::class => PaymentTableFactory::class
        ],
        'invokables' => [
            PaymentFilter::class => PaymentFilter::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];