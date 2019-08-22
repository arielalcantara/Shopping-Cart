<?php
namespace Cart\Model;

class CartItem
{
    public $cart_item_id;
    public $cart_id;
    public $product_id;
    public $weight;
    public $qty;
    public $unit_price;
    public $price;

    public function exchangeArray(array $data)
    {
        $this->cart_item_id     = !empty($data['cart_item_id']) ? $data['cart_item_id'] : null;
        $this->cart_id     = !empty($data['cart_id']) ? $data['cart_id'] : null;
        $this->product_id = !empty($data['product_id']) ? $data['product_id'] : null;
        $this->weight  = !empty($data['weight']) ? $data['weight'] : null;
        $this->qty     = !empty($data['qty']) ? $data['qty'] : null;
        $this->unit_price = !empty($data['unit_price']) ? $data['unit_price'] : null;
        $this->price  = !empty($data['price']) ? $data['price'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}