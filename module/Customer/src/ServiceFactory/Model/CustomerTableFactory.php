<?php
namespace Customer\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Customer\Model\Customer;
use Customer\Model\CustomerTable;

class CustomerTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('shopping_cart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Customer());
        $tableGateway = new TableGateway(
            'customers',
            $dbAdapter,
            null,
            $resultSetPrototype
        );

        return new CustomerTable($tableGateway);
    }
}