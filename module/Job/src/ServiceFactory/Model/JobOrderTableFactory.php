<?php
namespace Job\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Job\Model\JobOrder;
use Job\Model\JobOrderTable;

class JobOrderTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('shopping_cart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JobOrder());
        $tableGateway = new TableGateway(
            'job_orders',
            $dbAdapter,
            null,
            $resultSetPrototype
        );

        return new JobOrderTable($tableGateway);
    }
}