<?php
namespace Cart\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Cart\Model\Cart;
use Cart\Model\CartTable;

class CartTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('shopping_cart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Cart());
        $tableGateway = new TableGateway(
            'carts',
            $dbAdapter,
            null,
            $resultSetPrototype
        );

        return new CartTable($tableGateway);
    }
}