<?php
namespace Cart\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;

class CartItemTable
{
    private $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchCartItemByCartAndProduct($cart_id, $product_id)
    {
        $cart_id = (int) $cart_id;
        $product_id = (int) $product_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'cart_item_id',
            'weight',
            'qty',
            'price'
        ])->where([
            'cart_id'    => $cart_id,
            'product_id' => $product_id
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function insertCartItem($cartItem)
    {
        $data = [
            'cart_id' => $cartItem->cart_id,
            'product_id' => $cartItem->product_id,
            'weight' => $cartItem->weight,
            'qty' => $cartItem->qty,
            'unit_price' => $cartItem->unit_price,
            'price' => $cartItem->price
        ];
        $this->tableGateway->insert($data);

        return $this->tableGateway->getLastInsertValue();
    }

    public function updateCartItem($cart_item_id, $cartItem)
    {
        $data = [
            'weight' => $cartItem->weight,
            'qty' => $cartItem->qty,
            'price' => $cartItem->price
        ];
        
        return $this->tableGateway->update($data, ['cart_item_id' => $cart_item_id]);
    }

    public function fetchAllCartItems($cart_id)
    {
        $cart_id = (int) $cart_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'qty',
            'price',
            'p.product_name' => new Expression('product_name'),
            'p.product_desc' => new Expression('product_desc'),
            'p.unit_price' => new Expression('p.price'),
            'p.product_thumbnail' => new Expression('product_thumbnail'),
        ])->join(
            ['p' => 'products'],
            'cart_items.product_id = p.product_id',
            []
        )->where([
            'cart_id' => $cart_id
        ]);

        $result = $this->tableGateway->selectWith($select)->getDataSource();
        $resultArray = iterator_to_array($result);

        return $resultArray;
    }

    public function deleteCartItemByCart($cart_id)
    {
        $this->tableGateway->delete(['cart_id' => $cart_id]);
    }

    public function fetchCartItemsByCart($cart_id)
    {
        $cart_id = (int) $cart_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'product_id',
            'weight',
            'qty',
            'unit_price',
            'price'
        ])->where([
            'cart_id' => $cart_id
        ]);

        $result = $this->tableGateway->selectWith($select)->getDataSource();
        $resultArray = iterator_to_array($result);

        return $resultArray;
    }
}