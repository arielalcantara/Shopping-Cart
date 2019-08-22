<?php
namespace Customer\Filter;

use Psr\Container\ContainerInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\EmailAddress;
use Zend\Validator\Regex;

class RegistrationFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name'     => 'email',
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
                    'name' => 'EmailAddress',
                    'options' => [
                        'messages' => [
                            EmailAddress::INVALID_FORMAT => 'Invalid e-mail address.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'password',
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
                            NotEmpty::IS_EMPTY => 'Password is required.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'confirm_password',
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
                            NotEmpty::IS_EMPTY => 'Confirm password is required.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'company_name',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ]
        ]);

        $this->add([
            'name'     => 'first_name',
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
                            NotEmpty::IS_EMPTY => 'First name is required.'
                        ]
                    ]
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/[a-zA-Z ]*/',
                        'messages' => [
                            Regex::NOT_MATCH => 'Invalid first name. Disallowed characters found.'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name'     => 'last_name',
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
                            NotEmpty::IS_EMPTY => 'Last name is required.'
                        ]
                    ]
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/[a-zA-Z ]*/',
                        'messages' => [
                            Regex::NOT_MATCH => 'Invalid last name. Disallowed characters found.'
                        ]
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