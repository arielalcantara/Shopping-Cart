<?php
namespace Shipping\Model;

class Shipping
{
    public $shipping_id;
    public $min_weight;
    public $max_weight;
    public $shipping_method;
    public $shipping_rate;

    public function exchangeArray(array $data)
    {
        $this->shipping_id     = !empty($data['shipping_id']) ? $data['shipping_id'] : null;
        $this->min_weight  = !empty($data['min_weight']) ? $data['min_weight'] : null;
        $this->max_weight     = !empty($data['max_weight']) ? $data['max_weight'] : null;
        $this->shipping_method = !empty($data['shipping_method']) ? $data['shipping_method'] : null;
        $this->shipping_rate  = !empty($data['shipping_rate']) ? $data['shipping_rate'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}