<?php
namespace Customer\Model;

class Customer
{
    public $customer_id;
    public $email;
    public $password;
    public $company_name;
    public $first_name;
    public $last_name;
    public $phone;

    public function exchangeArray(array $data)
    {
        $this->customer_id     = !empty($data['customer_id']) ? $data['customer_id'] : '';
        $this->email  = !empty($data['email']) ? $data['email'] : '';
        $this->password     = !empty($data['password']) ? $data['password'] : '';
        $this->company_name = !empty($data['company_name']) ? $data['company_name'] : '';
        $this->first_name  = !empty($data['first_name']) ? $data['first_name'] : '';
        $this->last_name     = !empty($data['last_name']) ? $data['last_name'] : '';
        $this->phone = !empty($data['phone']) ? $data['phone'] : '';
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}