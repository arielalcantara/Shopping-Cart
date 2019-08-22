<?php
namespace Product\ServiceFactory\Service;

use Psr\Container\ContainerInterface;
use Product\Service\ProductService;

class ProductServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ProductService();
    }
}