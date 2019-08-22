<?php
namespace Shipping\Filter;

use Psr\Container\ContainerInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class ShippingFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name'     => 'shipping_name',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'E-mail address is required.'
                        ]
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 35,
                        'messages' => [
                            StringLength::TOO_LONG => 'Name must not exceed 35 characters.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'shipping_address1',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Shipping address is required.'
                        ]
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 35,
                        'messages' => [
                            StringLength::TOO_LONG => 'Shipping address must not exceed 35 characters.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'shipping_address2',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 35,
                        'messages' => [
                            StringLength::TOO_LONG => 'Shipping address must not exceed 35 characters.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'shipping_address3',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 35,
                        'messages' => [
                            StringLength::TOO_LONG => 'Shipping address must not exceed 35 characters.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'shipping_city',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'City is required.'
                        ]
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 35,
                        'messages' => [
                            StringLength::TOO_LONG => 'City name must not exceed 35 characters.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'shipping_state',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'State is required.'
                        ]
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 35,
                        'messages' => [
                            StringLength::TOO_LONG => 'State name must not exceed 35 characters.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'shipping_country',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Country is required.'
                        ]
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 35,
                        'messages' => [
                            StringLength::TOO_LONG => 'Country name must not exceed 35 characters.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'shipping_method',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty'
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'max' => 35
                    ]
                ]
            ]
        ]);
    }

    public function validateAndSanitizeInput($input)
    {   
        $this->setData($input);
        $filteredArray = $this->getValues();
        
        return $filteredArray;
    }
}