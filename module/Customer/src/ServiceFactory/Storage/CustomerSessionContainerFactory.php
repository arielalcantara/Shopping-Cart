<?php
namespace Customer\ServiceFactory\Storage;

use Psr\Container\ContainerInterface;
use Zend\Session\Container;

class CustomerSessionContainerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Container('customer');
    }
}