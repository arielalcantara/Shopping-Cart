<?php
namespace Product\Model;

class Product
{
    public $product_id;
    public $product_name;
    public $product_desc;
    public $product_image;
    public $product_thumbnail;
    public $weight;
    public $price;
    public $stock_qty;

    public function exchangeArray(array $data)
    {
        $this->product_id     = !empty($data['product_id']) ? $data['product_id'] : null;
        $this->product_name = !empty($data['product_name']) ? $data['product_name'] : null;
        $this->product_desc  = !empty($data['product_desc']) ? $data['product_desc'] : null;
        $this->product_image     = !empty($data['product_image']) ? $data['product_image'] : null;
        $this->product_thumbnail = !empty($data['product_thumbnail']) ? $data['product_thumbnail'] : null;
        $this->weight  = !empty($data['weight']) ? $data['weight'] : null;
        $this->price     = !empty($data['price']) ? $data['price'] : null;
        $this->stock_qty = !empty($data['stock_qty']) ? $data['stock_qty'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}