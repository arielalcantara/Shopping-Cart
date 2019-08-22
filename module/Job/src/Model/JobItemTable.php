<?php
namespace Job\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;

class JobItemTable
{
    private $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertJobItem($jobItem)
    {
        $data = [
            'job_order_id' => $jobItem['job_order_id'],
            'product_id'   => $jobItem['product_id'],
            'weight'       => $jobItem['weight'],
            'qty'          => $jobItem['qty'],
            'unit_price'   => $jobItem['unit_price'],
            'price'        => $jobItem['price']
        ];

        $this->tableGateway->insert($data);

        return $this->tableGateway->getLastInsertValue();
    }

    public function fetchAllJobItemsByJobOrder($job_order_id)
    {
        $job_order_id = (int) $job_order_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'qty',
            'price',
            'p.product_name' => new Expression('product_name'),
            'p.product_desc' => new Expression('product_desc'),
            'p.unit_price' => new Expression('p.price'),
            'p.product_thumbnail' => new Expression('product_thumbnail'),
        ])->join(
            ['p' => 'products'],
            'job_items.product_id = p.product_id',
            []
        )->where([
            'job_order_id' => $job_order_id
        ]);

        $result = $this->tableGateway->selectWith($select)->getDataSource();
        $resultArray = iterator_to_array($result);

        return $resultArray;
    }
}