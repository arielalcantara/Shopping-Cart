<?php
namespace Customer\Model;

use Zend\Db\TableGateway\TableGateway;

class CustomerTable
{
    private $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchCustomerInfo($customer_id)
    {
        $customer_id = (int) $customer_id;
        $select = $this->tableGateway->getSql()->select()->columns([
            'email',
            'first_name',
            'last_name',
            'company_name',
            'phone'
        ])->where([
            'customer_id' => $customer_id
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function fetchCustomerInfoByEmail($email)
    {
        $select = $this->tableGateway->getSql()->select()->columns([
            'customer_id',
            'first_name',
            'password'
        ])->where([
            'email' => $email
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function checkIfEmailExists($email)
    {
        $select = $this->tableGateway->getSql()->select()->columns([
            'email'
        ])->where([
            'email' => $email
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }

    public function insertCustomer($customer)
    {
        $data = [
            'email'        => $customer->email,
            'password'     => $customer->password,
            'company_name' => $customer->company_name,
            'first_name'   => $customer->first_name,
            'last_name'    => $customer->last_name
        ];
        $this->tableGateway->insert($data);

        return $this->tableGateway->getLastInsertValue();
    }

    public function fetchCustomerIdAndFirstNameByEmail($email)
    {
        $select = $this->tableGateway->getSql()->select()->columns([
            'customer_id',
            'first_name'
        ])->where([
            'email' => $email
        ]);
        $result = $this->tableGateway->selectWith($select)->getDataSource()->current();
        
        return $result;
    }
}