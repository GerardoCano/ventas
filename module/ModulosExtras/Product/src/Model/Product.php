<?php

namespace Product\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Product implements InputFilterAwareInterface
{
    public $id;
    public $name;
    public $in_stock;
    public $units_in_stock;
    public $unit_purchase_price;
    public $unit_sale_price;
    public $sp_id;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->in_stock = !empty($data['in_stock']) ? $data['in_stock'] : null;
        $this->units_in_stock  = !empty($data['units_in_stock']) ? $data['units_in_stock'] : null;
        $this->unit_purchase_price  = !empty($data['unit_purchase_price']) ? $data['unit_purchase_price'] : null;
        $this->unit_sale_price  = !empty($data['unit_sale_price']) ? $data['unit_sale_price'] : null;
        $this->sp_id  = !empty($data['sp_idsp_id']) ? $data['sp_id'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'in_stock' => $this->in_stock,
            'units_in_stock' => $this->units_in_stock,
            'unit_purchase_price' => $this->unit_purchase_price,
            'unit_sale_price' => $this->unit_sale_price,
            'sp_id' => $this->sp_id,
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
                        'max' => 150,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'in_stock',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'units_in_stock',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'unit_purchase_price',
            'required' => true,
            'filters' => [
                ['name' => ToDouble::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'unit_sale_price',
            'required' => true,
            'filters' => [
                ['name' => ToDouble::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'sp_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}