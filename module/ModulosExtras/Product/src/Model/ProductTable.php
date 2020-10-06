<?php

namespace Product\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class ProductTable
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

    public function getProduct($id)
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

    public function saveProduct(Product $product)
    {
        $data = [
            'name' => $product->name,
            'in_stock' => $product->in_stock,
            'units_in_stock'  => $product->units_in_stock,
            'unit_purchase_price'  => $product->unit_purchase_price,
            'unit_sale_price'  => $product->unit_sale_price,
            'sp_id'  => $product->sp_id ,
        ];

        $id = (int) $product->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getProduct($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update Product with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}