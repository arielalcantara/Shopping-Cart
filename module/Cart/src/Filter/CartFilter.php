<?php
namespace Cart\Filter;

use Zend\InputFilter\InputFilter;

class CartFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name'     => 'product_id',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ]
        ]);

        $this->add([
            'name'     => 'qty',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ]
        ]);
    }
}