<?php
namespace Cart\ServiceFactory\Service;

use Psr\Container\ContainerInterface;
use Cart\Service\CartItemService;

class CartItemServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CartItemService();
    }
}