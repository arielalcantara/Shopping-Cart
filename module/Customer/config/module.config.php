<?php
namespace Customer;

use Zend\Mvc\Router\Http\Segment;
use Customer\Controller\CustomerController;
use Customer\ServiceFactory\Controller\CustomerControllerFactory;
use Customer\Model\CustomerTable;
use Customer\ServiceFactory\Model\CustomerTableFactory;
use Customer\ServiceFactory\Storage\CustomerSessionContainerFactory;
use Customer\Filter\LoginFilter;
use Customer\Filter\RegistrationFilter;

return [
    'router' => [
        'routes' => [
            'customer' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/customer[/:action][&from=:from]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'from' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => CustomerController::class,
                        'action'     => 'showLoginAndRegistration'
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            CustomerController::class => CustomerControllerFactory::class,
        ],
    ],
   'service_manager' => [
       'factories' => [
            CustomerTable::class => CustomerTableFactory::class,
            'Customer\Storage\CustomerSessionContainer' => CustomerSessionContainerFactory::class
       ],
       'invokables' => [
            LoginFilter::class => LoginFilter::class,
            RegistrationFilter::class => RegistrationFilter::class
       ]
   ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];