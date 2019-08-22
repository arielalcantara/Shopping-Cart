<?php
namespace Cart\ServiceFactory\Service;

use Psr\Container\ContainerInterface;
use Cart\Service\CartService;

class CartServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CartService();
    }
}