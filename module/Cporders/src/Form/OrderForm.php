<?php

namespace Cporders\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Adapter\Driver\ResultInterface;

class OrderForm extends Form
{
    public function __construct($name = null)
    {
        $adapter = new Adapter([
            'driver'   => 'Pdo_Sqlite',
            'database' => __DIR__ . '/../../../../data/order.db',
        ]);

        $statement = $adapter->createStatement('SELECT id,first_name,last_name FROM customers');
        $statement->prepare();
        $result = $statement->execute();
        $dato = array();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);

            foreach ($resultSet as $row) {
                $dato += array($row->id => $row->last_name.' '.$row->first_name);
            }
        }
        $names = new Element\Select('ctm_id');
        $names->setLabel('Which the customer name');
        $names->setEmptyOption('Choose the customer name');
        $names->setValueOptions($dato);

        $element = new Element\Select('order_completed');
        $element->setLabel('¿Order Completed?');
        $element->setValueOptions([
            'Yes' => 'Yes',
            'No' => 'No'
        ]);

        // We will ignore the name provided to the constructor
        parent::__construct('order');

        $this->add([
            'name' => 'o_id',
            'type' => 'hidden',
        ]);
        $this->add($names);
        $this->add([
            'name' => 'date_order_placed',
            'type' => 'date',
            'options' => [
                'label' => 'Date Order Placed',
            ],
        ]);
        $this->add([
            'name' => 'time_order_placed',
            'type' => 'text',
            'options' => [
                'label' => 'Units in stock',
            ],
        ]);
        $this->add([
            'name' => 'total_product_no',
            'type' => 'text',
            'options' => [
                'label' => 'Unit Purchase Price',
            ],
        ]);
        $this->add($element);
        $this->add([
            'name' => 'date_order_completed',
            'type' => 'date',
            'options' => [
                'label' => 'Date Order Completed',
            ],
        ]);
        $this->add([
            'name' => 'any_additional_info',
            'type' => 'text',
            'options' => [
                'label' => 'Additional Info',
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
