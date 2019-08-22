<?php
namespace Job;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        //Attach render errors

         $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, function($e) {
         if ($e->getParam('exception')) {
         $this->exception($e->getParam('exception')) ; //Custom error render function.
         }
         } );
         // Attach dispatch errors
         $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function($e) {
         if ($e->getParam('exception')) {
         $this->exception($e->getParam('exception')) ;//Custom error render function.
         }
         });
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    private function exception($e) {
     echo "<div style=\"margin-top:100px;\"><span style='font-family: courier new; padding: 2px 5px; background:red; color: white;'> " . $e->getMessage() . '</span><br/></div>';
     echo "<pre>" . $e->getTraceAsString() . '</pre>' ;
     }
}