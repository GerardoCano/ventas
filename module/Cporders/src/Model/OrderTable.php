<?php

namespace Cporders\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class OrderTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select(function (Select $select) {
            $select->join('customers','ctm_id = customers.id');
        });
    }

    public function getOrder($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['o_id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveOrder(Order $order)
    {
        $data = [
            'ctm_id' => $order->ctm_id,
            'date_order_placed' => $order->date_order_placed,
            'time_order_placed'  => $order->time_order_placed,
            'total_product_no'  => $order->total_product_no,
            'order_completed'  => $order->order_completed,
            'date_order_completed'  => $order->date_order_completed,
            'any_additional_info'  => $order->any_additional_info,
        ];

        $id = (int) $order->o_id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getOrder($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update Order with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['o_id' => $id]);
    }

    public function deleteOrder($id)
    {
        $this->tableGateway->delete(['o_id' => (int) $id]);
    }
}