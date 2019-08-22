<?php
namespace Job\ServiceFactory\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Job\Model\JobItem;
use Job\Model\JobItemTable;

class JobItemTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get('shopping_cart');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JobItem());
        $tableGateway = new TableGateway(
            'job_items',
            $dbAdapter,
            null,
            $resultSetPrototype
        );

        return new JobItemTable($tableGateway);
    }
}