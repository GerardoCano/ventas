<?php

namespace Product\Form;

use Laminas\Form\Form;

class ProductForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('product');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Product Name',
            ],
        ]);
        $this->add([
            'name' => 'in_stock',
            'type' => 'text',
            'options' => [
                'label' => 'Products in Stock?',
            ],
        ]);
        $this->add([
            'name' => 'units_in_stock',
            'type' => 'text',
            'options' => [
                'label' => 'Units in stock',
            ],
        ]);
        $this->add([
            'name' => 'unit_purchase_price',
            'type' => 'text',
            'options' => [
                'label' => 'Unit Purchase Price',
            ],
        ]);
        $this->add([
            'name' => 'unit_sale_price',
            'type' => 'text',
            'options' => [
                'label' => 'Unit Sale Price',
            ],
        ]);
        $this->add([
            'name' => 'sp_id',
            'type' => 'text',
            'options' => [
                'label' => 'Supplier Name',
            ],
        ]);
    }
}