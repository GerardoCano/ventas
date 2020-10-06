<?php

namespace Cporders\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Filter\ToFloat;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Order implements InputFilterAwareInterface
{
    public $o_id;
    public $ctm_id;
    public $date_order_placed;
    public $time_order_placed;
    public $total_product_no;
    public $order_completed;
    public $date_order_completed;
    public $any_additional_info;
    
    public $first_name;
    public $last_name;

    private $inputFilter;
        

    public function exchangeArray(array $data)
    {
        $this->o_id = !empty($data['o_id']) ? $data['o_id'] : null;
        $this->ctm_id = !empty($data['ctm_id']) ? $data['ctm_id'] : null;
        $this->date_order_placed = !empty($data['date_order_placed']) ? $data['date_order_placed'] : null;
        $this->time_order_placed  = !empty($data['time_order_placed']) ? $data['time_order_placed'] : null;
        $this->total_product_no  = !empty($data['total_product_no']) ? $data['total_product_no'] : null;
        $this->order_completed  = !empty($data['order_completed']) ? $data['order_completed'] : null;
        $this->date_order_completed  = !empty($data['date_order_completed']) ? $data['date_order_completed'] : null;
        $this->any_additional_info  = !empty($data['any_additional_info']) ? $data['any_additional_info'] : null;
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->ctm_name = $this->first_name. " ".$this->last_name;
    }

    public function getArrayCopy()
    {
        return [
            'o_id' => $this->o_id,
            'ctm_id' => $this->ctm_id,
            'date_order_placed' => $this->date_order_placed,
            'time_order_placed' => $this->time_order_placed,
            'total_product_no' => $this->total_product_no,
            'order_completed' => $this->order_completed,
            'date_order_completed' => $this->date_order_completed,
            'any_additional_info' => $this->any_additional_info,
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
            'name' => 'o_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'ctm_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'date_order_placed',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'time_order_placed',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'total_product_no',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'order_completed',
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
                        'min' => 2,
                        'max' => 3,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'date_order_completed',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'any_additional_info',
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
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}