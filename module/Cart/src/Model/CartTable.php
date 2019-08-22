<?php
namespace Cart\Model;

use Zend\Db\TableGateway\TableGateway;

class CartTable
{
    private $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchCart($cart_id)
    {
        $cart_id = (int) $cart_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'customer_id',
            'order_datetime',
            'sub_total',
            'shipping_total',
            'total_amount',
            'total_weight',
            'company_name',
            'email',
            'first_name',
            'last_name',
            'phone',
            'shipping_method',
            'shipping_name',
            'shipping_address1',
            'shipping_address2',
            'shipping_address3',
            'shipping_city',
            'shipping_state',
            'shipping_country'
        ])->where([
            'cart_id' => $cart_id
        ]);
        $result = $this->tableGateway->selectWith($select)->current();
        
        return $result;
    }

    public function fetchCartTotals($cart_id)
    {
        $cart_id = (int) $cart_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'sub_total',
            'shipping_total',
            'total_amount',
            'total_weight'   
        ])->where([
            'cart_id' => $cart_id
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function updateCart($cart_id, $cart)
    {
        $data = [
            'sub_total'    => $cart->sub_total,
            'total_amount' => $cart->total_amount,
            'total_weight' => $cart->total_weight,
        ];

        return $this->tableGateway->update($data, ['cart_id' => $cart_id]);
    }

    public function insertCart($cart)
    {
        if ($cart->customer_id != 0) {
            $data = [
                'customer_id'    => $cart->customer_id,
                'order_datetime' => date("Y-m-d H:i:s"),
                'sub_total'      => $cart->sub_total,
                'total_amount'   => $cart->total_amount,
                'total_weight'   => $cart->total_weight,
                'company_name'   => $cart->company_name,
                'email'          => $cart->email,
                'first_name'     => $cart->first_name,
                'last_name'      => $cart->last_name,
                'phone'          => $cart->phone
            ];
        } else {
            $data = [
                'customer_id'    => 0,
                'order_datetime' => date("Y-m-d H:i:s"),
                'sub_total'      => $cart->sub_total,
                'total_amount'   => $cart->total_amount,
                'total_weight'   => $cart->total_weight
            ];
        }

        $this->tableGateway->insert($data);

        return $this->tableGateway->getLastInsertValue();
    }

    public function fetchCartIdByCustomer($customer_id)
    {
        $customer_id = (int) $customer_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'cart_id'
        ])->where([
            'customer_id' => $customer_id
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function updateCartCustomerIdByCart($customer_id, $cart_id)
    {
        $customer_id = (int) $customer_id;
        $cart_id = (int) $cart_id;
        $data = [
            'customer_id' => $customer_id
        ];

        return $this->tableGateway->update($data, ['cart_id' => $cart_id]);
    }

    public function deleteCart($cart_id)
    {
        $this->tableGateway->delete(['cart_id' => $cart_id]);
    }

    public function fetchCartTotalWeight($cart_id)
    {
        $cart_id = (int) $cart_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'total_weight' 
        ])->where([
            'cart_id' => $cart_id
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function fetchCartTotalWeightAndSubTotal($cart_id)
    {
        $cart_id = (int) $cart_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'total_weight',
            'sub_total'    
        ])->where([
            'cart_id' => $cart_id
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function updateCartShippingDetails($cart_id, $cart)
    {
        $data = [
            'shipping_total'    => $cart->shipping_total,
            'total_amount'      => $cart->total_amount,
            'shipping_method'   => $cart->shipping_method,
            'shipping_name'     => $cart->shipping_name,
            'shipping_address1' => $cart->shipping_address1,
            'shipping_address2' => $cart->shipping_address2,
            'shipping_address3' => $cart->shipping_address3,
            'shipping_city'     => $cart->shipping_city,
            'shipping_state'    => $cart->shipping_state,
            'shipping_country'  => $cart->shipping_country
        ];

        return $this->tableGateway->update($data, ['cart_id' => $cart_id]);
    }

    public function updateCartTotals($cart_id, $cart)
    {
        $data = [
            'shipping_total'    => $cart->shipping_total,
            'total_amount'      => $cart->total_amount
        ];

        return $this->tableGateway->update($data, ['cart_id' => $cart_id]);
    }

    public function fetchCartTotalsAndShippingMethod($cart_id)
    {
        $cart_id = (int) $cart_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'total_weight',
            'sub_total',
            'shipping_method'
        ])->where([
            'cart_id' => $cart_id
        ]);
        $result = $this->tableGateway->selectWith($select)->current();
        
        return $result;
    }
}