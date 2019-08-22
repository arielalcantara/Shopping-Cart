<?php
namespace Product\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductTable
{
    private $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAllProducts()
    {
        return $this->tableGateway->select();
    }

    public function fetchProduct($product_id)
    {
        $product_id = (int) $product_id;
        $rowset = $this->tableGateway->select([
            'product_id' => $product_id
        ]);
        $row = $rowset->current();

        return $row;
    }

    public function fetchProductInfo($product_id)
    {
        $product_id = (int) $product_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'weight',
            'price',
            'stock_qty'
        ])->where([
            'product_id' => $product_id
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }
}