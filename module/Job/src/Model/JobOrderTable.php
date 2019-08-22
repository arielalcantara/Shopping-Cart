<?php
namespace Job\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;

class JobOrderTable
{
    private $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertJobOrder($jobOrder)
    {
        $data = [
            'customer_id'       => $jobOrder->customer_id,
            'order_datetime'    => $jobOrder->order_datetime,
            'sub_total'         => $jobOrder->sub_total,
            'shipping_total'    => $jobOrder->shipping_total,
            'total_amount'      => $jobOrder->total_amount,
            'total_weight'      => $jobOrder->total_weight,
            'company_name'      => $jobOrder->company_name,
            'email'             => $jobOrder->email,
            'first_name'        => $jobOrder->first_name,
            'last_name'         => $jobOrder->last_name,
            'phone'             => $jobOrder->phone,
            'shipping_method'   => $jobOrder->shipping_method,
            'shipping_name'     => $jobOrder->shipping_name,
            'shipping_address1' => $jobOrder->shipping_address1,
            'shipping_address2' => $jobOrder->shipping_address2,
            'shipping_address3' => $jobOrder->shipping_address3,
            'shipping_city'     => $jobOrder->shipping_city,
            'shipping_state'    => $jobOrder->shipping_state,
            'shipping_country'  => $jobOrder->shipping_country
        ];

        $this->tableGateway->insert($data);

        return $this->tableGateway->getLastInsertValue();
    }

    public function fetchJobOrderIdByCustomerAndDateTime($customer_id, $order_datetime)
    {
        $cart_id = (int) $cart_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'job_order_id'
        ])->where([
            'customer_id' => $customer_id,
            'order_datetime' => $order_datetime
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function fetchJobOrder($job_order_id)
    {
        $job_order_id = (int) $job_order_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'shipping_name',
            'shipping_address1',
            'shipping_city',
            'shipping_state',
            'shipping_country',
            'sub_total',
            'shipping_total',
            'total_amount',
            'total_weight'   
        ])->where([
            'job_order_id' => $job_order_id
        ]);
        $result = $this->tableGateway->selectWith($select)->current();
        
        return $result;
    }
}