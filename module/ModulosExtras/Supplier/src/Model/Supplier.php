<?php

namespace Supplier\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Supplier implements InputFilterAwareInterface
{
    public $id;
    public $name;
    public $address_street;
    public $address_city;
    public $address_country;
    public $address_post_code;
    public $phone_no;
    public $fax_no;
    public $payment_terms;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->address_street  = !empty($data['address_street']) ? $data['address_street'] : null;
        $this->address_city  = !empty($data['address_city']) ? $data['address_city'] : null;
        $this->address_country  = !empty($data['address_country']) ? $data['address_country'] : null;
        $this->address_post_code  = !empty($data['address_post_code']) ? $data['address_post_code'] : null;
        $this->phone_no = !empty($data['phone_no']) ? $data['phone_no'] : null;
        $this->fax_no = !empty($data['fax_no']) ? $data['fax_no'] : null;
        $this->payment_terms = !empty($data['payment_terms']) ? $data['payment_terms'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'address_street' => $this->address_street,
            'address_city' => $this->address_city,
            'address_country' => $this->address_country,
            'address_post_code' => $this->address_post_code,
            'phone_no' => $this->phone_no,
            'fax_no' => $this->fax_no,
            'payment_terms' => $this->payment_terms,
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
            'name' => 'name',
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
                        'max' => 7,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'phone_no',
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

        $inputFilter->add([
            'name' => 'fax_no',
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

        $inputFilter->add([
            'name' => 'payment_terms',
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

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}