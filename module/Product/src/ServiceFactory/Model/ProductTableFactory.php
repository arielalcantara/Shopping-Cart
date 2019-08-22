<?php
namespace Product\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Product\Model\Product;
use Product\Model\ProductTable;

class ProductTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('shopping_cart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Product());
        $tableGateway = new TableGateway(
            'products',
            $dbAdapter,
            null,
            $resultSetPrototype
        );
        
        return new ProductTable($tableGateway);
    }
}