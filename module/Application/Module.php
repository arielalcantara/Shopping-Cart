<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Customer\ServiceFactory\Storage\CustomerSessionContainer;
use Cart\ServiceFactory\Storage\CartSessionContainer;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $viewModel = $e->getViewModel();
        $serviceManager = $e->getApplication()->getServiceManager();
        $customerSession = $serviceManager->get('Customer\Storage\CustomerSessionContainer');
        // $cartSession = $serviceManager->get('Cart\Storage\CartSessionContainer');
        $viewModel->customer = [
            'first_name' => $customerSession->offsetGet('first_name')
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    // private function startSession(MvcEvent $e)
    // {
    //     $sm = $e->getApplication()->getServiceManager();
    //     $config = $sm->get('Config');
    //     $sessionConfig = new SessionConfig();
    //     $sessionConfig->setOptions($config['session']);
    //     $sessionManager = new SessionManager($sessionConfig);
    //     $sessionManager->start();
    // }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
