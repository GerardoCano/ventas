<?php

namespace Cporders\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Adapter\Driver\ResultInterface;

class ProductForm extends Form
{
    public function __construct($name = null)
    {
        $adapter = new Adapter([
            'driver'   => 'Pdo_Sqlite',
            'database' => __DIR__ . '/../../../../data/order.db',
        ]);

        $statement = $adapter->createStatement('SELECT name,id FROM suppliers');
        $statement->prepare();
        $result = $statement->execute();
        $dato = array();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);

            foreach ($resultSet as $row) {
                $dato += array($row->id => $row->name);
            }
        }
        $names = new Element\Select('sp_id');
        $names->setLabel('Which the supplier name');
        //$names->setOptions($valores);
        $names->setEmptyOption('Seleccione un vendedor');
        $names->setValueOptions($dato);

        $element = new Element\Select('in_stock');
        $element->setLabel('Are products in stock?');
        $element->setValueOptions([
            'Yes' => 'Yes',
            'No' => 'No'
        ]);

        // We will ignore the name provided to the constructor
        parent::__construct('product');

        $this->add([
            'name' => 'p_id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'p_name',
            'type' => 'text',
            'options' => [
                'label' => 'Product Name',
            ],
        ]);
        $this->add($element);
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
        $this->add($names);
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
