<?php

namespace Order\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Customer\Model\CustomerTable;
use Laminas\View\Model\ViewModel;

class OrderForm extends Form
{
    private $table;

    // Add this constructor:
    public function __construct(CustomerTable $table)
    {
        $this->table = $table;
        
        // We will ignore the name provided to the constructor
        parent::__construct('order');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'ctm_id',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Customer Name',
                'empty_option' => 'Please choose a Customer',
            ],
        ]);

        $this->add([
            'name' => 'first_name',
            'type' => 'text',
            'options' => [
                'label' => 'Customer First Name',
            ],
        ]);
        $this->add([
            'name' => 'last_name',
            'type' => 'text',
            'options' => [
                'label' => 'Customer Last Name',
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
            'name' => 'contact_phone_no',
            'type' => 'text',
            'options' => [
                'label' => 'Phone Number',
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