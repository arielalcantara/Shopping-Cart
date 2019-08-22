<?php
namespace Job;

use Zend\Mvc\Router\Http\Segment;
use Job\Controller\JobController;
use Job\ServiceFactory\Controller\JobControllerFactory;
use Job\Model\JobOrderTable;
use Job\ServiceFactory\Model\JobOrderTableFactory;
use Job\Model\JobItemTable;
use Job\ServiceFactory\Model\JobItemTableFactory;
use Job\ServiceFactory\Storage\JobSessionContainerFactory;

return [
    'router' => [
        'routes' => [
            'job' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/job[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => JobController::class,
                        'action'     => 'showOrderConfirmation',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            JobController::class => JobControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            JobOrderTable::class => JobOrderTableFactory::class,
            JobItemTable::class => JobItemTableFactory::class,

            'Job\Storage\JobSessionContainer' => JobSessionContainerFactory::class
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