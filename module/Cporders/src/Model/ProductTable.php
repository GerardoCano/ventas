<?php

namespace Cporders\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class ProductTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select(function (Select $select) {
            $select->join('suppliers','sp_id = suppliers.id');
        });
    }

    public function getProduct($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['p_id' => $id]);
        $row = $rowset->current();
        if (!$row) {
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
            'p_name' => $product->p_name,
            'in_stock' => $product->in_stock,
            'units_in_stock'  => $product->units_in_stock,
            'unit_purchase_price'  => $product->unit_purchase_price,
            'unit_sale_price'  => $product->unit_sale_price,
            'sp_id'  => $product->sp_id,
        ];

        $id = (int) $product->p_id;

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

        $this->tableGateway->update($data, ['p_id' => $id]);
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(['p_id' => (int) $id]);
    }
}
