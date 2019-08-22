<?php
namespace Shipping\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Shipping\Model\Shipping;
use Shipping\Model\ShippingTable;

class ShippingTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('shopping_cart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Shipping());
        $tableGateway = new TableGateway(
            'shipping',
            $dbAdapter,
            null,
            $resultSetPrototype
        );

        return new ShippingTable($tableGateway);
    }
}