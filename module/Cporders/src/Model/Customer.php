<?php

namespace Cporders\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Customer implements InputFilterAwareInterface
{
    public $id;
    public $first_name;
    public $last_name;
    public $address_street;
    public $address_city;
    public $address_country;
    public $address_post_code;
    public $contact_phone_no;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->address_street  = !empty($data['address_street']) ? $data['address_street'] : null;
        $this->address_city  = !empty($data['address_city']) ? $data['address_city'] : null;
        $this->address_country  = !empty($data['address_country']) ? $data['address_country'] : null;
        $this->address_post_code  = !empty($data['address_post_code']) ? $data['address_post_code'] : null;
        $this->contact_phone_no = !empty($data['contact_phone_no']) ? $data['contact_phone_no'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'=> $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address_street' => $this->address_street,
            'address_city' => $this->address_city,
            'address_country' => $this->address_country,
            'address_post_code' => $this->address_post_code,
            'contact_phone_no' => $this->contact_phone_no,
        ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'first_name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'last_name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 120,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'address_street',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 150,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'address_city',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 150,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'address_country',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 150,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'address_post_code',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 10,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'contact_phone_no',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 10,
                        'max' => 16,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}