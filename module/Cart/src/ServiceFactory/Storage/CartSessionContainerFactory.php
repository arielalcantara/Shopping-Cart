<?php
namespace Cart\ServiceFactory\Storage;

use Psr\Container\ContainerInterface;
use Zend\Session\Container;

class CartSessionContainerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Container('cart');
    }
}