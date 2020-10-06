<?php

namespace Cporders\Form;

use Laminas\Form\Form;

class SupplierForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('supplier');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Supplier Name',
            ],
        ]);
        $this->add([
            'name' => 'address_street',
            'type' => 'text',
            'options' => [
                'label' => 'Address Street',
            ],
        ]);
        $this->add([
            'name' => 'address_city',
            'type' => 'text',
            'options' => [
                'label' => 'Address City',
            ],
        ]);
        $this->add([
            'name' => 'address_country',
            'type' => 'text',
            'options' => [
                'label' => 'Address Country',
            ],
        ]);
        $this->add([
            'name' => 'address_post_code',
            'type' => 'text',
            'options' => [
                'label' => 'Address Post Code',
            ],
        ]);
        $this->add([
            'name' => 'phone_no',
            'type' => 'text',
            'options' => [
                'label' => 'Phone Number',
            ],
        ]);
        $this->add([
            'name' => 'fax_no',
            'type' => 'text',
            'options' => [
                'label' => 'Fax Number',
            ],
        ]);
        $this->add([
            'name' => 'payment_terms',
            'type' => 'text',
            'options' => [
                'label' => 'Payment Terms',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Submit',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}