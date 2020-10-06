<?php

namespace Supplier\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class SupplierTable
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

    public function getSupplier($id)
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

    public function saveSupplier(Supplier $supplier)
    {
        $data = [
            'name' => $supplier->name,
            'address_street'  => $supplier->address_street,
            'address_city'  => $supplier->address_city,
            'address_country'  => $supplier->address_country,
            'address_post_code'  => $supplier->address_post_code,
            'phone_no'  => $supplier->phone_no,
            'fax_no'  => $supplier->fax_no,
            'payment_terms'  => $supplier->payment_terms,
        ];

        $id = (int) $supplier->id;

        //Se modificó esta condicion para que permita la inserción de los datos
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getSupplier($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update supplier with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteSupplier($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}