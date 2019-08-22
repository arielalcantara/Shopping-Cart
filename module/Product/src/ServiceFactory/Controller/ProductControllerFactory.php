<?php
namespace Product\ServiceFactory\Controller;

use Psr\Container\ContainerInterface;
use Product\Controller\ProductController;
use Product\Model\ProductTable;

class ProductControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        $productTable = $container->get(ProductTable::class);

        return new ProductController($productTable);
    }
}