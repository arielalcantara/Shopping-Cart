<?php
namespace Job\Model;

class JobOrder
{
    public $job_order_id;
    public $customer_id;
    public $sub_total;
    public $shipping_total;
    public $total_amount;
    public $total_weight;
    public $email;
    public $first_name;
    public $last_name;
    public $company_name;
    public $phone;
    public $shipping_method;
    public $shipping_name;
    public $shipping_address1;
    public $shipping_address2;
    public $shipping_address3;
    public $shipping_city;
    public $shipping_state;
    public $shipping_country;

    public function exchangeArray(array $data)
    {
        $this->job_order_id     = !empty($data['job_order_id']) ? $data['job_order_id'] : '';
        $this->customer_id = !empty($data['customer_id']) ? $data['customer_id'] : '';
        $this->sub_total  = !empty($data['sub_total']) ? $data['sub_total'] : '';
        $this->shipping_total     = !empty($data['shipping_total']) ? $data['shipping_total'] : '';
        $this->total_amount = !empty($data['total_amount']) ? $data['total_amount'] : '';
        $this->total_weight  = !empty($data['total_weight']) ? $data['total_weight'] : '';
        $this->email  = !empty($data['email']) ? $data['email'] : '';
        $this->first_name  = !empty($data['first_name']) ? $data['first_name'] : '';
        $this->last_name  = !empty($data['last_name']) ? $data['last_name'] : '';
        $this->company_name  = !empty($data['company_name']) ? $data['company_name'] : '';
        $this->phone  = !empty($data['phone']) ? $data['phone'] : '';
        $this->shipping_method  = !empty($data['shipping_method']) ? $data['shipping_method'] : '';
        $this->shipping_name  = !empty($data['shipping_name']) ? $data['shipping_name'] : '';
        $this->shipping_address1  = !empty($data['shipping_address1']) ? $data['shipping_address1'] : '';
        $this->shipping_address2  = !empty($data['shipping_address2']) ? $data['shipping_address2'] : '';
        $this->shipping_address3  = !empty($data['shipping_address3']) ? $data['shipping_address3'] : '';
        $this->shipping_city  = !empty($data['shipping_city']) ? $data['shipping_city'] : '';
        $this->shipping_state  = !empty($data['shipping_state']) ? $data['shipping_state'] : '';
        $this->shipping_country  = !empty($data['shipping_country']) ? $data['shipping_country'] : '';
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}