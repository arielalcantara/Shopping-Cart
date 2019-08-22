<?php
namespace Customer\Filter;

use Psr\Container\ContainerInterface;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\EmailAddress;

class LoginFilter extends InputFilter
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
            'name'     => 'url',
            'required' => false,
            'filters'  => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
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