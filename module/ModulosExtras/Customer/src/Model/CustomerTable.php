<?php

namespace Customer\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class CustomerTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getCustomer($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveCustomer(Customer $customer)
    {
        $data = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'address_street'  => $customer->address_street,
            'address_city'  => $customer->address_city,
            'address_country'  => $customer->address_country,
            'address_post_code'  => $customer->address_post_code,
            'contact_phone_no'  => $customer->contact_phone_no,
        ];

        $id = (int) $customer->id;

        //Se modificó esta condicion para que permita la inserción de los datos
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getCustomer($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update Customer with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteCustomer($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}