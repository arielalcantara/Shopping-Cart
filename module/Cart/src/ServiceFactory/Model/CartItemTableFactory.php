<?php
namespace Cart\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Cart\Model\CartItem;
use Cart\Model\CartItemTable;

class CartItemTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('shopping_cart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new CartItem());
        $tableGateway = new TableGateway(
            'cart_items',
            $dbAdapter,
            null,
            $resultSetPrototype
        );

        return new CartItemTable($tableGateway);
    }
}